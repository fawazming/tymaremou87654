<?php
namespace App\Controllers;

class Home extends BaseController
{
	public function index($key='')
	{
		$session = session();
		if ($session->logged_in == TRUE) {
			$session = session();
			if ($session->clearance == 11) {
				return redirect()->to('oga');
			}else{
                return redirect()->to('db');
            }
		} else {
			$this->login($key);
		}
	}

    public function postlogin()
    {
      $users = new \App\Models\Users();
        $key = $this->request->getPost('key');
        $result = $users->where('ky', $key)->find();

        if ($result) {
            $ses_data = [
                'id' => $result[0]['ky'],
                'ky' => $result[0]['id'],
                'email' => $result[0]['email'],
                'clearance' => $result[0]['clearance'],
                'logged_in' => TRUE,
            ];
            $session = session();
            $session->set($ses_data);
            return redirect()->to(base_url('/'));
        } else {
            echo 'Login not Successful';
        }
    }

    private function KeyGen()
    {
        $alph = '01234567890ABCDEFGHIJKLMNOPQRSTUVWXXYZabcdefghijklmnoppqrstuvvwxzzyy';
        return substr(str_shuffle($alph),2,18);
    }

    public function postregister()
    {
        $users = new \App\Models\Users();
        $email = $this->request->getPost('email');
        $key = $this->KeyGen();

        $res = $users->insert(['ky'=>$key, 'email'=>$email, 'bal'=>0, 'clearance'=>1]);

        if($res){
            // Send Email
            $data = [
                    'to' => $email,
                    'type' => 'link',
                    'subject' => 'Welcome to Giftful',
                    'message' => ['p1' => 'You are highly welcome to the community.', 'p2'=>'Your account has been created and your login key is <b>'.$key.'</b>', 'p3' => 'You can reach our support line via 2348108097322(whatsapp)', 'link'=>'https://giftful.sgm.ng/'.$key.'', 'linktext'=>'Click here direct access to your dashboard']
                ];
                if ($this->mailer($data)) {
                    echo view('header');
                    echo view('msg', ['msg'=>'Account Created <br> Check your email for Login Details']);
                    echo view('footer');
                }
        }else{
            echo 'Error while Submitting';
        }
    }

    public function login($key='')
    {
        echo view('header');
        echo view('login', ['key'=>$key]);
        echo view('footer');
    }

    private function api($url)
    {
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $url);
        return $response;
    }

    public function db()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $session = session();

            $users = new \App\Models\Users();

            $response = $this->api('https://www.nellobytesystems.com/APIDatabundlePlansV1.asp');
            $dataPlans = json_decode($response->getBody());
            // dd($dataPlans);
            $mtn = $dataPlans->MOBILE_NETWORK->MTN[0]->PRODUCT;
            $mtnPlans = '';
            foreach ($mtn as $key => $mt) {
                $amt = (ceil(($mt->PRODUCT_AMOUNT*0.16)+$mt->PRODUCT_AMOUNT));
                $pid = '01,'.$mt->PRODUCT_ID.','.$amt;
                if($key < 5){
                $mtnPlans .= "
                <div class='col-6 p-1'>
                    <button style='border: 0 red solid;' class='btn p-0 bg-transparent' onclick='dataBuy("."`".$pid."`".")'>
                    <div class='card'>
                        <div class='card-body p-1 text-center'>
                            <h5 class='mb-0 pb-1'>".$mt->PRODUCT_NAME."</h5>
                            <p class='card-text'>
                                ₦ ".$amt."
                            </p>
                        </div>
                    </div>
                    </button>
                </div>";
            }
            }

            $arl = $dataPlans->MOBILE_NETWORK->Airtel[0]->PRODUCT;
            $arlPlans = '';
            foreach ($arl as $key => $al) {
                $amt = ($al->PRODUCT_AMOUNT);
                if($key < 12){
                $arlPlans .= "
                <div class='col-6 p-1'>
                    <button style='border: 0 red solid;' class='btn p-0 bg-transparent' onclick='dataBuy(`04,".$al->PRODUCT_ID.','.$amt."`)'>
                    <div class='card'>
                        <div class='card-body p-1 text-center'>
                            <h5 class='mb-0 pb-1'>".$al->PRODUCT_NAME."</h5>
                            <p class='card-text'>
                                ₦ ".$amt."
                            </p>
                        </div>
                    </div>
                    </button>
                </div>";
            }
            }


            $glo = $dataPlans->MOBILE_NETWORK->Glo[0]->PRODUCT;
            $gloPlans = '';
            foreach ($glo as $key => $mt) {
                $amt = (ceil(($mt->PRODUCT_AMOUNT*0.08)+$mt->PRODUCT_AMOUNT));
                // if($key < 5){
                $gloPlans .= "
                <div class='col-6 p-1'>
                    <button style='border: 0 red solid;' class='btn p-0 bg-transparent' onclick='dataBuy(`02,".$mt->PRODUCT_ID.','.$amt."`)'>
                    <div class='card'>
                        <div class='card-body p-1 text-center'>
                            <h5 class='mb-0 pb-1'>".$mt->PRODUCT_NAME."</h5>
                            <p class='card-text'>
                                ₦ ".$amt."
                            </p>
                        </div>
                    </div>
                    </button>
                </div>";
            // }
            }

            $n9mb = '9mobile';
            $nmb = $dataPlans->MOBILE_NETWORK->$n9mb[0]->PRODUCT;
            $nmbPlans = '';
            foreach ($nmb as $key => $mt) {
                // if($key < 5){
                $amt = (ceil(($mt->PRODUCT_AMOUNT*0.08)+$mt->PRODUCT_AMOUNT));
                $nmbPlans .= "
                <div class='col-6 p-1'>
                    <button style='border: 0 red solid;' class='btn p-0 bg-transparent' onclick='dataBuy(`03,".$mt->PRODUCT_ID.','.$amt."`)'>
                    <div class='card'>
                        <div class='card-body p-1 text-center'>
                            <h5 class='mb-0 pb-1'>".$mt->PRODUCT_NAME."</h5>
                            <p class='card-text'>
                                ₦ ".$amt."
                            </p>
                        </div>
                    </div>
                    </button>
                </div>";
            // }
            }



            echo view('oheader', ['bal'=> $users->where('ky', $session->id)->find()[0]['bal']]);
            echo view('db', [
                'mtn' => $mtnPlans,
                'arl' => $arlPlans,
                'glo' => $gloPlans,
                'nmb' => $nmbPlans,

                ]);

        } else {
            $this->login();
        }
    }


    public function lpin()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $session = session();

            $users = new \App\Models\Users();

            echo view('oheader', ['bal'=> $users->where('ky', $session->id)->find()[0]['bal']]);
            echo view('lpin', []);
            echo view('footer');

        } else {
            $this->login();
        }
    }


    public function postlpin()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $session = session();
            $pin = $this->request->getPost('pin');
            $users = new \App\Models\Users();
            $pins = new \App\Models\Pins();
            $Logs = new \App\Models\Logs();

            $bal = $users->where('ky', $session->id)->find()[0]['bal'];
            $res = $pins->where('pin',$pin)->find();
            if($res){
                if($res[0]['used']){
                    $this->msg('This PIN has already been Used');
                }else{
                    $users->update($session->ky, ['bal'=>($bal+$res[0]['worth']) ]);
                    $pins->update($res[0]['id'], ['used'=>1]);

                    $data = [
                        'pin'=>$pin,
                        'worth'=>$res[0]['worth'],
                        'owner'=>$session->email,
                        'balBefore'=>$bal,
                    ];
                    // Log
                    $Logs->insert(['type'=>'Pin','log'=>json_encode($data)]);
                    $this->msg('Pin Load Successful <br> You Just Topped up ₦'.$res[0]['worth']);
                }
            }else{
                $this->msg('Invalid or Incorrect Pin. <br> Please Check the PIN and Try Again');
            }

        } else {
            $this->login();
        }
    }

    public function buyData()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $session = session();
            $incoming = $this->request->getPost();
            $users = new \App\Models\Users();
            $Logs = new \App\Models\Logs();

            $plan = explode(',', $incoming['plan'])[1];
            $network = explode(',', $incoming['plan'])[0];
            $amt = explode(',', $incoming['plan'])[2];
            $phone = $incoming['phone'];

            if($plan == '00'){
                $bal = $users->where('ky', $session->id)->find()[0]['bal'];
                if($amt > $bal){
                    $this->msg('Insufficient Balance. <br> Your bill is ₦'.$amt.'  <br> Buy another airtime lesser than ₦'.$bal);
                }else{
                    $users->update($session->ky, ['bal'=>($bal-$amt)]);
                     // Call API
                    $api = $this->api('https://www.nellobytesystems.com/APIAirtimeV1.asp?UserID='.$_ENV['userID'].'&APIKey='.$_ENV['CKkey'].'&MobileNetwork='.$network.'&Amount='.$amt.'&MobileNumber='.$phone.'&CallBackURL=http://rayyantech.sgm.ng');
                    $data = [
                        'network'=>$network,
                        'amt'=>$amt,
                        'owner'=>$session->email,
                        'balBefore'=>$bal,
                        'apiRes'=>$api->getBody(),
                    ];
                    // Log
                    $Logs->insert(['type'=>'BuyAirtime','log'=>json_encode($data)]);
                    $this->msg('Payment Successful <br> Your Airtime will arrive anytime soon');
                }
            }else{

                $bal = $users->where('ky', $session->id)->find()[0]['bal'];
                if($amt > $bal){
                    $this->msg('Insufficient Balance. <br> Your bill is ₦'.$amt.'  <br> Buy another plan lesser than ₦'.$bal);
                }else{
                    $users->update($session->ky, ['bal'=>($bal-$amt)]);
                     // Call API
                    $api = $this->api('https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID='.$_ENV['userID'].'&APIKey='.$_ENV['CKkey'].'&MobileNetwork='.$network.'&DataPlan='.$plan.'&MobileNumber='.$phone.'&CallBackURL=http://rayyantech.sgm.ng');
                    // https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=CK8102&APIKey=M2XJD61H4ELMJ308UHG7S1GVM34H533668D2ZL9YT663E1MYO6366JNEN75CB608&MobileNetwork=${a}&DataPlan=${e}&MobileNumber=${n}&CallBackURL=http://rayyan.com.ng
                    $data = [
                        'network'=>$network,
                        'plan'=>$plan,
                        'amt'=>$amt,
                        'owner'=>$session->email,
                        'balBefore'=>$bal,
                        'apiRes'=>$api->getBody(),
                    ];
                    // Log
                    $Logs->insert(['type'=>'BuyData','log'=>json_encode($data)]);
                    $this->msg('Payment Successful <br> Your Data will arrive anytime soon');
                }
            }



        } else {
            $this->login();
        }
    }

    public function msg($msg)
    {
        $session = session();
        $users = new \App\Models\Users();
        echo view('oheader', ['bal'=> $users->where('ky', $session->id)->find()[0]['bal']]);
        echo view('msg', ['msg'=>$msg]);
        echo view('footer');
    }

    public function register()
    {
        echo view('header');
        echo view('register');
        echo view('footer');
    }

	public function sendscores($quizid = 0)
	{
		$session = session();
		if ($session->logged_in == TRUE) {
			$scoresheet = new \App\Models\Scoresheet();
			$users = new \App\Models\Users();
			$Quiz = new \App\Models\Quiz();
			$qlast = $quizid ? $quizid :  $Quiz->orderBy('id', 'desc')->first()['code'];
			$res = $scoresheet->where('sent', '0')->find();
	
			$coo = $this->test($qlast,1);
			foreach ($res as $key => $rs) {
				$db = $users->where('id', $rs['user'])->find();
				$data = [
					'to' => $db[0]['email'],
					'type' => 'link',
					'subject' => 'Score Released - PHF Ogun Quiz',
					'message' => ['p1' => 'Your score has been released for PHF Ogun Monthly Quiz', 'p2'=>'Your Score is '.$rs['score'].'/15.', 'p3' => 'Do join us next Month for another exciting edition.', 'link'=>'https://quiz.phfogun.org/solution/'.$coo.'', 'linktext'=>'Click here for answers to the questions'],
					'response' => [
						'title' => 'Scores Sent',
						'msg' => 'All scores has been sent out to the provided email',
						'url' => base_url('login'),
					]
				];
				if ($this->mailer($data)) {
					$scoresheet->update($rs['id'], ['sent' => '1']);
				}
			}
			$this->msg([
				'title' => 'Scores Sent',
				'msg' => 'All scores has been sent out to the provided email',
				'url' => base_url('login'),
			]);
		} else {
			$this->login();
		}
	}

	public function mailer(array $data)
	{
		$email = \Config\Services::email();
		$email->setFrom($_ENV['smtpuser'], $_ENV['smtpName']);
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
		echo $email->printDebugger(['headers', 'subject', 'body']);
	}


	public function message($type, $data)
	{
		// $data params
		// 	p1 -- Paragraph 1
		// 	p2 -- Paragraph 2
		// 	p3 -- Paragraph 3
		// 	link -- href link
		// 	linktext -- Display Text

		if ($type == 'link') {
			$output = "
            <!doctype html>
			<html>
			<head>
				<meta name='viewport' content='width=device-width'>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<title>Rayyantech</title>
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
								<span class='apple-link' style='color: #999999; font-size: 12px; text-align: center;'><a href='https://rayyantech.sgm.ng'>Rayyan Technologies</a>, Sagamu</span>
								
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

	public function logout()
	{
		$session = session();
		$session->destroy();
		return redirect()->to(base_url());
	}

	//--------------------------------------------------------------------

    private function pgen()
    {
        $config         = new \Config\Encryption();
        $config->key    = $_ENV['encKey'];
        $config->driver = 'OpenSSL';

        $encrypter = \Config\Services::encrypter($config);

        $val1 = bin2hex($ciphertext = $encrypter->encrypt('This is a plain-text message!'));
        $val2 = substr($val1, 0, 6);
        return $this->numbequiv($val2);
    }


    private function numbequiv($string)
    {
        $kye = str_split($_ENV['kye']);
        $string = str_split($string);
        $out = '';

        foreach ($string as $ky => $ch) {
                $found = array_search($ch, $kye);
                $out = $out.$found;
        }
        return $out;
    }

    public function oga()
    {
        echo view('oga');
    }

    public function poga()
    {
        $incoming = $this->request->getPost();
        $login = [
            'uname' => $_ENV['uname'],
            'pword' => $_ENV['pword'],
        ];
        if($incoming == $login){
            $response = $this->api('https://www.nellobytesystems.com/APIWalletBalanceV1.asp?UserID='.$_ENV['userID'].'&APIKey='.$_ENV['CKkey']);
            $balance = $response->getBody();
            //
            echo view('dashboard', ['bal' => $balance, 'mod' => $_ENV['mod']]);
        }else{
            echo "Get out of here";
        }
    }


    public function genpin()
    {
        $Pins = new \App\Models\Pins();

        $incoming = $this->request->getPost();
        $error = '';
        $collated = [];

        if(empty($incoming['phone'])){
            $error = $error.' No Phone Number,';
        }
        if(($incoming['worth']) == ''){
            $error = $error.' Select a network,';
        }
        if(empty($incoming['quantity'])){
            $error = $error.' Select number of pin to gen';
        }

        $rounds = $incoming['quantity'];
        if(empty($error)){
            for ($i=0; $i < $rounds; $i++) {
                $collated[$i] = [
                    'pin' => $this->pgen(),
                    'worth' => $incoming['worth'],
                    'phone' => $incoming['phone'],
                    'used' => 0
                ];
            }
            $extractedPins = [];
            foreach ($collated as $ky => $col) {
                $extractedPins[$ky] = $col['pin'];
             }

            $res = $Pins->insertBatch($collated);

            if($res){return view('generatedpins', [
                'pins' => $extractedPins,
                'agent'=> $incoming['phone'],
                'quantity' => $incoming['quantity'],
                'worth' => $incoming['worth'],
            ]);}

            // var_dump($extractedPins);

        }else{
            echo 'I cannot proceed because of error: <br> '. $error;
        }


    }

    public function writesms()
    {
        echo view('writesms');
    }

    public function sms()
    {
        $incoming = $this->request->getGet();
        $res = $this->sendsms($incoming['ph'], $incoming['sm']);
        if($res){
            // echo "SMS sent to ".$incoming['ph'];
            var_dump($res);
        }else{
            echo "Error while sending";
        }
    }

    public function sendsms($phone, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.dojah.io/api/v1/messaging/sms",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\"sender_id\":\"PawmNG\",\"destination\":\"".$phone ."\",\"channel\":\"sms\",\"message\":\"".$message."\"}",
          CURLOPT_HTTPHEADER => [
            "Accept: text/plain",
            "AppId: ".$_ENV['AppId'],
            "Authorization: ".$_ENV['ProdKey'],
            "Content-Type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
          // return $err;
        } else {
          return $response;
            // return true;
        }
    }



}
