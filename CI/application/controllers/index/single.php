<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Single extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	}

	public function findSingle($pid)
	{
		//look up single product 
		$data=array();
		$this->load->view('single.html',$data);
	}

	  public function addToCart() {
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        $amount = $_POST['amount'];
        $stock = $this->product_model->checkProductStock($pid);
        if ($amount > $stock) {
            //echo out of stock
        } else {
            $this->cart_model->addToCart($user, $pid, $amount);
            $this->product_model->decreaseProductAmount($pid);
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */