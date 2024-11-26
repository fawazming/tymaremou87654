<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$session = session();
		$logged_in = $session->get('admin_logged_in');
		if ($logged_in) {
			return redirect()->to(base_url('dashboard'));
		} else {
			echo view('login');
		}
	}

	public function auth()
	{
		$session = session();
		$uname = $this->request->getPost('username');
		$password = $this->request->getPost('password');
		$year = $this->request->getPost('year');


		if ($uname == 'tyma' && $password == 'tymaremo2024') {
			$newdata = array(
				'admin' => $uname,
				'year' => $year,
				'admin_logged_in' => TRUE
			);
			$session->set($newdata);
			return redirect()->to(base_url('dashboard'));
		} else {
			return redirect()->to(base_url('/'));
		}
	}

	public function logout()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {
			session()->destroy();
			return redirect()->to(base_url('/'));
		} else {
			echo view('login');
		}
	}

	public function dashboard()
	{
		// echo('dashboard');	
		$logged_in = session()->get('admin_logged_in');
		// $Delegates = new \App\Models\Delegates();
		// $ManualDel = new \App\Models\ManualDel();
		if ($logged_in) {
			$year = session()->get('year');
			if($year == 'current'){
				$Delegates = new \App\Models\Delegates();
			}else{
				$Delegates = new \App\Models\DelegatesOld();
			}

			$data = [
				'total_del' => $Delegates->countAll(),
				'male' => $Delegates->where('gender', 'male')->countAllResults(),
				'female' => $Delegates->where('gender', 'female')->countAllResults(),
			];

			echo view('header', ['zone' => $_ENV['zone']]);
			echo view('dashboard', $data);
			echo view('footer');
		} else {
			echo view('login');
		}
	}

	public function manual()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {

			echo view('header', ['zone' => $_ENV['zone']]);
			echo view('manualUpload');
			echo view('footer');
		} else {
			echo view('login');
		}
	}

	public function manual1()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {

			echo view('header', ['zone' => $_ENV['zone']]);
			echo view('manualUpload1', $this->request->getGet());
			echo view('footer');
		} else {
			echo view('login');
		}
	}

	public function manual2()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {

			$manual = new \App\Models\ManualDel();
			$incoming = $this->request->getPost();
			$res = $manual->insert($incoming);

			return redirect()->back();
		} else {
			echo view('login');
		}
	}

    public function pins()
    {
        $logged_in = session()->get('admin_logged_in');
        if ($logged_in) {
			$year = session()->get('year');
			if($year == 'current'){
				$Pins = new \App\Models\Pins();
			}else{
				$Pins = new \App\Models\PinsOld();
			}

            $data = array(
                'pins' => $Pins->findAll()
            );

			echo view('header', ['zone' => $_ENV['zone']]);
            echo view('pins', $data);
            echo view('footer');
        } else {
            echo view('login');
        }
    }

	public function printe()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {
			$year = session()->get('year');
			if($year == 'current'){
				$Delegates = new \App\Models\Delegates();
				// $record = $Delegates->join('pins_24', 'pin = ref')->findAll();
			}else{
				$Delegates = new \App\Models\DelegatesOld();
			}

			$data = array(
				'delegates' => $Delegates->findAll(),
				'type' => 'Electronic'
			);

			echo view('header', ['zone' => $_ENV['zone']]);
			echo view('print', $data);
			echo view('footer');
		} else {
			echo view('login');
		}
	}

	public function printm()
	{
		$logged_in = session()->get('admin_logged_in');
		if ($logged_in) {
			$Delegates = new \App\Models\ManualDel();

			$data = array(
				'delegates' => $Delegates->findAll(),
				'type' => 'Electronic'
			);

			echo view('header', ['zone' => $_ENV['zone']]);
			echo view('print', $data);
			echo view('footer');
		} else {
			echo view('login');
		}
	}


    public function tag()
    {
        $logged_in = session()->get('admin_logged_in');
        if ($logged_in) {
            $Pins = new \App\Models\Pins();
            $Delegates = new \App\Models\Delegates();

            $data = [
                'tdel' => $Delegates->countAll()
            ];

			echo view('header', ['zone' => $_ENV['zone']]);
            echo view('tag', $data);
            echo view('footer');
        } else {
            echo view('login');
        }
    }


    public function printtag()
    {
        $logged_in = session()->get('admin_logged_in');
        if ($logged_in) {
            $incoming = $this->request->getPost();
            $range = explode('-',$incoming['range']);

            $Delegates = new \App\Models\Delegates();
            $del = '';
            if(count($range)==1){
                $del = $Delegates->where('id',$range[0])->find();
            }else{
                $del = [];
                for ($i=$range[0]; $i < ($range[1]+1); $i++) {
                   array_push($del,$Delegates->where('id', $i)->find());
                }
            }

            echo view('tags', ['del'=>$del]);
        } else {
            echo view('login');
        }
    }


	//--------------------------------------------------------------------

}
