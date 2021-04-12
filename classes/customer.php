<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
/**
 * 
 */
class customer
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	public function insert_binhluan()
	{
		$product_id = $_POST['product_id_binhluan'];
		$tenbinhluan = $_POST['tennguoibinhluan'];
		$binhluan = $_POST['binhluan'];
		if ($tenbinhluan == '' || $binhluan == '') {
			$alert = "<span class='error'>Some Fields Is Null</span>";
			return $alert;
		} else {
			$query = "INSERT INTO tbl_binhluan(tenbinhluan,binhluan,product_id) VALUES('$tenbinhluan','$binhluan','$product_id')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='success'>Comment Sent</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Comment Failed.</span>";
				return $alert;
			}
		}
	}
	public function insert_mess($userName)
	{
		$MessUser = $_POST['messsend'];
		$date = date('m/d/Y h:i:sa', time());
		if ($MessUser == '' || $MessUser == '') {
			$alert = "<span class='error'>Message Fields Is Null</span>";
			return $alert;
		} else {
			$query = "INSERT INTO tbl_chat(userName,MessUser,NgaySend) VALUES('$userName','$MessUser','$date')";
			$result = $this->db->insert($query);
		}
	}
	public function admin_reply($chatId)
	{
		$MessAdmin = $_POST['messadmin'];
		$date = date('m/d/Y h:i:sa', time());
		if ($MessAdmin == '' || $MessAdmin == '') {
			$alert = "<span class='error'>Message Fields Is Null</span>";
			return $alert;
		} else {
			$query = "UPDATE tbl_chat SET reply_admin='$MessAdmin', NgayRep='$date' WHERE chatId ='$chatId'";
			$result = $this->db->update($query);
		}
	}
	public function show_mess_forid($userName)
	{
		$query = "SELECT * FROM tbl_chat WHERE userName='$userName' order by NgaySend desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function show_chat()
	{
		$query = "SELECT * FROM tbl_chat order by chatId desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function get_userName_by_chatId($chatId)
	{
		$check_login = "SELECT * FROM tbl_chat WHERE chatId='$chatId'";
		$result_chat = $this->db->select($check_login);
		if ($result_chat) {
			$value = $result_chat->fetch_assoc();
			Session::set('check_user', true);
			$result = Session::set('userName', $value['userName']);
			return $result;
		}
	}
	public function del_comment($id)
	{
		$query = "DELETE FROM tbl_binhluan where binhluan_id = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='success'>Delete Comment Successfully</span>";
			return $alert;
		} else {
			$alert = "<span class='error'>Delete Comment is not Success</span>";
			return $alert;
		}
	}
	public function show_comment()
	{
		$query = "SELECT * FROM tbl_binhluan order by binhluan_id desc";
		$result = $this->db->select($query);
		return $result;
	}
	public function insert_customers($data)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$city = mysqli_real_escape_string($this->db->link, $data['city']);
		$zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$country = mysqli_real_escape_string($this->db->link, $data['country']);
		$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if ($name == "" || $city == "" || $zipcode == "" || $email == "" || $address == "" || $country == "" || $phone == "" || $password == "") {
			$alert = "<span class='error'>Fields must be not empty</span>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$alert = "<span class='error'>Email Already Existed ! Please Enter Another Email</span>";
				return $alert;
			} else {
				$query = "INSERT INTO tbl_customer(name,city,zipcode,email,address,country,phone,password) VALUES('$name','$city','$zipcode','$email','$address','$country','$phone','$password')";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<span class='success'>Customer Created Successfully</span>";
					return $alert;
				} else {
					$alert = "<span class='error'>Customer Created Not Successfully</span>";
					return $alert;
				}
			}
		}
	}
	public function login_customers($data)
	{
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if ($email == '' || $password == '') {
			$alert = "<span class='error'>Password and Email must be not empty</span>";
			return $alert;
		} else {
			$check_login = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
			$result_check = $this->db->select($check_login);
			if ($result_check) {

				$value = $result_check->fetch_assoc();
				Session::set('customer_login', true);
				Session::set('customer_id', $value['id']);
				Session::set('customer_name', $value['name']);
				// $alert = "<span class='success'>Login Success <a href='payment.php'>Go to Paypal</a></span>";
				// return $alert;
				echo "<script>window.location ='index.php'</script>";
			} else {
				$alert = "<span class='error'>Email or Password doesn't match</span>";
				return $alert;
			}
		}
	}
	public function show_customers($id)
	{
		$query = "SELECT * FROM tbl_customer WHERE id='$id'";
		$result = $this->db->select($query);
		return $result;
	}
	public function update_customers($data, $id)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$phone = mysqli_real_escape_string($this->db->link, $data['phone']);

		if ($name == "" || $zipcode == "" || $email == "" || $address == "" || $phone == "") {
			$alert = "<span class='error'>Fields must be not empty</span>";
			return $alert;
		} else {
			$query = "UPDATE tbl_customer SET name='$name',zipcode='$zipcode',email='$email',address='$address',phone='$phone' WHERE id ='$id'";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='success'>Customer Updated Successfully</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Customer Updated Not Successfully</span>";
				return $alert;
			}
		}
	}
}
?>