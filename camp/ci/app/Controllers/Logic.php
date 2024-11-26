<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Logic extends BaseController
{
	use ResponseTrait;

	public function index()
	{
        echo view('header', ['zone' => $_ENV['zone']]);
        echo view('options', ['year' => $_ENV['year'], 'earlyFee'=>$_ENV['earlyFee'], 'lateFee'=>$_ENV['lateFee']]);
		echo view('footer');
	}

	public function buypin()
	{
        echo view('header', ['zone' => $_ENV['zone']]);
        echo view('buypin');
		echo view('footer');
	}

    public function payonline()
    {
        echo view('header');
        echo view('payonline');
        echo view('footer');
    }

	public function register($pin = '')
	{
        echo view('header', ['zone' => $_ENV['zone']]);
        echo view('pin', ['pin'=>$pin]);
		echo view('footer');
	}

	public function pinstatus()
	{
        echo view('header', ['zone' => $_ENV['zone']]);
        echo view('pinstatus');
		echo view('footer');
	}

	public function vendors()
	{
		echo view('vendors');
	}

	public function msg($mg = "Hello")
	{
        echo view('header', ['zone' => $_ENV['zone']]);
		echo view('msg', ['mg' => $mg]);
        echo view('footer');
	}

	public function pin()
	{
		$incoming = $this->request->getGet();
		$Pins = new \App\Models\Pins();
		if($value = $Pins->where(['pin'=>$incoming['pin'],'used !='=>1])->find()){
            echo view('header', ['zone' => $_ENV['zone']]);
			echo view('home',['ref'=>$incoming['pin']]);
            echo view('footer');

		}else{
			$this->msg("The pin you entered is invalid");
		}
	}

	public function pinstat()
	{
		$incoming = $this->request->getGet();
		$Pins = new \App\Models\Pins();

		$value = $Pins->where(['pin'=>$incoming['pin']])->find();
		$this->msg("Is the pin used? ". $this->boolconv($value[0]['used']));
		
	}

    private function boolconv($v)
    {
        switch ($v) {
            case '0':
                return 'No';
                break;

            case '1':
                return 'Yes';
                break;

            default:
                return 'Unknown';
                break;
        }
    }

	public function registration()
	{
		$incoming = $this->request->getPost();
		$Pins = new \App\Models\Pins();
        $Delegates = new \App\Models\Delegates();
            $pin = $Pins->where('pin',$incoming['ref'])->find()[0];
            if($pin['used'] == 1){
                $this->msg('Sorry, this pin has been used.');
            }else{
    		  $id = $Delegates->insert($incoming);
    		  $Pins->update($pin['id'],['used'=>'1']);
    		  $this->msg('Congratulations! Your registration was successful <br> Reg. No: <b> '.$id.'</b>');
    		}
	}

	public function sms()
	{
		$incoming = $this->request->getJSON();
		$Alerts = new \App\Models\Alerts();
		$res = $Alerts->insert(['message' => $incoming->message]);

		$data = [
			'message' => 'created' . $res
		];
		if ($res) {
			return $this->respond($data, 200);
		} else {
			return $this->respond(['message' => 'Not Added'], 400);
		}
	}

	public function uniqidReal($lenght = 4) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			echo("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}

		
	public function samp()
	{
        // echo (WRITEPATH);
        $Pins = new \App\Models\Pins();

        for ($i=1; $i <= 1000; $i++) {
            $p = strtoupper($this->uniqidReal(6));
            echo ($i.' '.$p.'<br>');
            $id = $Pins->insert(['pin'=> $p]);

        }
        // echo ($this->uniqidReal(16));

	}


    public function proceedOnline()
    {
        $Tranx = new \App\Models\Tranx();
       $incoming = $this->request->getPost();
       $amt = 500000;
       $payment = $this->genPayLink($incoming['email'], $amt);
        $payData = json_decode($payment['response']);
        $payRef = $payment['ref'];
        $data = [
            'email' => $incoming['email'],
            'status' => 'Intialize',
            'ref' => $payRef,
            'url' => $payData->data->checkout_url
        ];
        $Tranx->insert($data);
        return redirect()->to($payData->data->checkout_url);
    }

    public function webhook()
    {
        $Alerts = new \App\Models\Alerts();
        $Tranx = new \App\Models\Tranx();

        $incoming = json_encode($this->request->getVar());
        $id = $Alerts->insert(['message'=>$incoming, 'linked'=>0]);
        $dt = json_decode($incoming);
        $tranx = $Tranx->where('ref',$dt->ref)->find()[0];
        $Tranx->update($tranx['id'], ['status'=>$dt->stat]);

        if($dt->stat == 'success'){
            $Pins = new \App\Models\Pins();
            $pins = $Pins->where('vendor','new')->find()[0];
            $Pins->update($pins['id'], ['vendor'=>'online']);
            $data = [
                    'to' => $tranx['email'],
                    'type' => 'link',
                    'subject' => 'PMC Pin Purchase Successful',
                    'message' => ['p1' => 'Al hamdulillah! Your pin purchase was successful.', 'p2'=>'Your Pin is '.$pins['pin'].'', 'p3' => 'Do continue your registeration by visiting https://camp.phfogun.org/register.', 'link'=>'https://camp.phfogun.org/register/'.$pins['pin'].'', 'linktext'=>'Click here to continue your registeration'],
                ];
                if ($this->mailer($data)) {
                    $Tranx->update($tranx['id'], ['status'=>$pins['pin']]);
                }
        }
    }

    private function genPayLink($email,$amt)
    {
        $ref = uniqid('phf22_', true);
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.collect.africa/payments/initialize",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\"email\":\"".$email."\",\"amount\":".$amt.",\"reference\":\"".$ref."\"}",
          CURLOPT_HTTPHEADER => [
            "Authorization: Bearer ".$_ENV['paySK']."",
            "accept: application/json",
            "content-type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return ['response'=>$response,'ref' => $ref];
        }
    }


    public function mailer(array $data)
    {
        $email = \Config\Services::email();
        $email->setFrom('quiz@phfogun.org', 'PHF Camp');
        $email->setTo($data['to']);
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject($data['subject']);
        $email->setMessage($this->message($data['type'], $data['message']));

        if ($email->send()) {
            return 1;
        } else {
            return 0;
        }
        // $this->msg($data['response']);

        echo $email->printDebugger(['headers', 'subject', 'body']);
    }


    public function message($type, $data)
    {
        // $data params
        //  p1 -- Paragraph 1
        //  p2 -- Paragraph 2
        //  p3 -- Paragraph 3
        //  link -- href link
        //  linktext -- Display Text

        if ($type == 'link') {
            $output = "
            <!doctype html>
            <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>PHF Camp</title>
                <style>
                    @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }

                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }

                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }

                    table[class=body] .content {
                        padding: 0 !important;
                    }

                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }

                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }

                    table[class=body] .btn table {
                        width: 100% !important;
                    }

                    table[class=body] .btn a {
                        width: 100% !important;
                    }

                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                    }
                    @media all {
                    .ExternalClass {
                        width: 100%;
                    }

                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }

                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }

                    #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                    }

                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }

                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                    }
                </style>
            </head>
            <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;' width='100%' bgcolor='#f6f6f6'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi there,</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p1'] . "</p>
                                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='btn btn-primary' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: border-box; width: 100%;' width='100%'>
                                    <tbody>
                                        <tr>
                                        <td align='left' style='font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;' valign='top'>
                                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;'>
                                            <tbody>
                                                <tr>
                                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #3498db;' valign='top' align='center' bgcolor='#3498db'> <a href='" . $data['link'] . "' target='_blank' style='border: solid 1px #3498db; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; text-transform: capitalize; background-color: #3498db; border-color: #3498db; color: #ffffff;'>" . $data['linktext'] . "</a> </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p2'] . "</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p3'] . "</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- END CENTERED WHITE CONTAINER -->

                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #999999; font-size: 12px; text-align: center;'>Pure Heart Islamic Foundation, Ogun State</span>

                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>

                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->

                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
            </html>
        ";
        } else if ($type == 'text') {
            // Just one p1
            $output = "
            <!doctype html>
            <html>
            <head>
                <meta name='viewport' content='width=device-width'>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <title>PHF Camp</title>
                <style>
                    @media only screen and (max-width: 620px) {
                    table[class=body] h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important;
                    }

                    table[class=body] p,
                    table[class=body] ul,
                    table[class=body] ol,
                    table[class=body] td,
                    table[class=body] span,
                    table[class=body] a {
                        font-size: 16px !important;
                    }

                    table[class=body] .wrapper,
                    table[class=body] .article {
                        padding: 10px !important;
                    }

                    table[class=body] .content {
                        padding: 0 !important;
                    }

                    table[class=body] .container {
                        padding: 0 !important;
                        width: 100% !important;
                    }

                    table[class=body] .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important;
                    }

                    table[class=body] .btn table {
                        width: 100% !important;
                    }

                    table[class=body] .btn a {
                        width: 100% !important;
                    }

                    table[class=body] .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important;
                    }
                    }
                    @media all {
                    .ExternalClass {
                        width: 100%;
                    }

                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                        line-height: 100%;
                    }

                    .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important;
                    }

                    #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                    }

                    .btn-primary table td:hover {
                        background-color: #34495e !important;
                    }

                    .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important;
                    }
                    }
                </style>
            </head>
            <body class='' style='background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;'>
                <span class='preheader' style='color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0;'>" . substr($data['p1'], 0, 70) . "</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;' width='100%' bgcolor='#f6f6f6'>
                <tr>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                    <td class='container' style='font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto;' width='580' valign='top'>
                    <div class='content' style='box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;'>

                        <!-- START CENTERED WHITE CONTAINER -->
                        <table role='presentation' class='main' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;' width='100%'>

                        <!-- START MAIN CONTENT AREA -->
                        <tr>
                            <td class='wrapper' style='font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;' valign='top'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                <tr>
                                <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>Hi there,</p>
                                    <p style='font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;'>" . $data['p1'] . "</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>

                        <!-- END MAIN CONTENT AREA -->
                        </table>
                        <!-- END CENTERED WHITE CONTAINER -->

                        <!-- START FOOTER -->
                        <div class='footer' style='clear: both; margin-top: 10px; text-align: center; width: 100%;'>
                        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                            <tr>
                            <td class='content-block' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>
                                <span class='apple-link' style='color: #999999; font-size: 12px; text-align: center;'>Pure Heart Islamic Foundation, Ogun State</span>

                            </td>
                            </tr>
                            <tr>
                            <td class='content-block powered-by' style='font-family: sans-serif; vertical-align: top; padding-bottom: 10px; padding-top: 10px; color: #999999; font-size: 12px; text-align: center;' valign='top' align='center'>

                            </td>
                            </tr>
                        </table>
                        </div>
                        <!-- END FOOTER -->

                    </div>
                    </td>
                    <td style='font-family: sans-serif; font-size: 14px; vertical-align: top;' valign='top'>&nbsp;</td>
                </tr>
                </table>
            </body>
            </html>
        ";
        }
        return $output;
    }
	//--------------------------------------------------------------------

}
//
//
