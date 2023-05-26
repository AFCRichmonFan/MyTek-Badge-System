 <?php
	  class Pages extends Controller {
		public function __construct(){
			$this->tableModel = $this->model('Table');     
		}
		
		public function index(){
		  $data = [
			'title' => 'Badges'
		  ];
		  $this->view('pages/index', $data);
		}
		public function login($error=0){

		$errorMsg = "";

		if($error == 1){
			$errorMsg = "Please make sure you entered a username and a password";
		} else if ($error == 2){
			$errorMsg = "Sorry, your username or password was incorrect";
		} else if ($error == 3){
			$errorMsg = "Please login to use this feature of the site";
		}

		  $data = [
			'title' => 'Login',
			'error'=> $errorMsg
		  ];

		  $this->view('pages/login', $data);
		}

		public function awardBadge($var = 0, $varType = 0){		

		$badge = "";
		$user = "";
		$error = "";

		$errors = [
			"That badge or user dosen't exsist",
		];

		if($varType == 0 and $var != 0){
			$badge = $var;
		} else if ($varType == 1 and $var != 0){
			$user = $var;
		} else if ($varType == 2 and $var != 0){
			$error = $errors[$var];
		}


		  $data = [
			'title' => 'Award Badge',
			"badge" => $badge,
			"user" => $user,
			"error" => $error
		  ];

		  $this->view('pages/awardBadge', $data);
			
		}

		public function addBadges(){
			
			$AuthLevel = 2;
		  
			$categories = "";

			$userToken = @$_SESSION['token'];

			$catData = $this->tableModel->getBadgeCategories();

			foreach($catData as $c){
				$categories = $categories ."<option value=\"$c->badge_category_id\">$c->cat_name</option>";
			}


			$auth = $this->tableModel->auth($userToken);
			$auth = $auth[0]->acessLevel;

			if($auth < $AuthLevel or $auth == null) {
				$auth = "Only admins may use this feature of the site";
				redirect('pages/login/3');
			}

		  $data = [
			'title' => 'Add Badges',
			'categories' => $categories,
			'auth' => $auth
		  ];

		  $this->view('pages/addBadges', $data);

		}
		
		public function editBadge($id=0){

			$AuthLevel = 1;

			$categories = "";

			$userToken = @$_SESSION['token'];

			$catData = $this->tableModel->getBadgeCategories();

			$badgeData = $this->tableModel->getBadgeData($id)[0];

			foreach($catData as $c){
				$categories = $categories."<option value=\"$c->badge_category_id\"";
				
				if($c->cat_name === $badgeData->cat_name){
					$categories = $categories . ' selected = "selected"';
				}

				$categories = $categories . " >$c->cat_name</option>";

			}


			$auth = $this->tableModel->auth($userToken);
			$auth = $auth[0]->acessLevel;

			if( $auth < 1
			or $auth == null) {
				$auth = "Only admins may use this feature of the site";
				redirect("pages/login/3");
			}

		  $data = [
			'title' => "Edit Badge",
			'categories' => $categories,
			'auth' => $auth,
			'editInfo' => $badgeData
		  ];

		  $this->view('pages/editBadge', $data);

		}


		public function editBadgeProcess($id){
		  
			$name = $_POST['badge_name'];
			$desc = $_POST['badge_description'];
			$req = $_POST['badge_requirements'];
			$link = $_POST['badge_requirements'];
			$cat = $_POST['badge_category'];
			$link = $_POST['img'];
			$hidden = $_POST['hidden'];
			
			
			$returnID = $this->tableModel->editBadge($id,$name,$desc,$req,$link,$cat,$hidden);

		  $data = [
			'title' => 'secret',
			'name' => $cat
		  ];

				redirect("pages/viewBadges/10/$id");
				//$this->view('pages/editBadgeProcess', $data);

		}
		

		public function addBadgesProcess(){
		  
			$name = $_POST['badge_name'];
			$desc = $_POST['badge_description'];
			$req = $_POST['badge_requirements'];
			$link = $_POST['badge_requirements'];
			$cat = $_POST['badge_category'];
			$link = $_POST['img'];
			$hidden = $_POST['hidden'];
			
			$userToken = @$_SESSION['token'];

			$auth = $this->tableModel->auth($userToken);
			$id = $auth[0]->login_id;
			
			$returnID = $this->tableModel->addBadge($id,$name,$desc,$req,$link,$cat,$hidden);


	  $data = [
        'title' => 'secret',
		'name' => $name
      ];

			$this->view('pages/addBadgesProcess', $data);

	}

	public function loginProcess(){

		//get our username and password from the form
		$username = @$_POST['username'];
		$password = @$_POST['password'];

		//if either of these are not submitted redirect back to the login page with an error message
		if($username == ""){
			redirect('pages/login/1');
			exit();
		}

		//run the login function from the model with our username and password from the form
		$loginInfo = $this->tableModel->login($username, $password);

		//if nothing is returned from the model
		if(count($loginInfo) == 0){
			redirect('pages/login/2'); //redirect back to the login with an error saying incorrect username or password
		} else { //if something is returned the login was a sucess
			$token = $this->tableModel->genNewToken($username);

			$_SESSION['username'] = $username;
			$_SESSION['token'] = $token;

			
			//['username'];
			//$this->view('pages/loginProcess', $data);
			redirect('pages/index');
		}
	}

	public function viewBadges($limit = 10, $offset = 0,$category='0',$order = 0){
		
		$AuthLevel = 1;
		
		$userToken = @$_SESSION['token'];
		$auth = $this->tableModel->auth($userToken);
		$auth = @$auth[0]->acessLevel;
		if($auth >= $AuthLevel){
			redirect("pages/viewBadgesAdmin/$limit/$offset/$category/$order");
		}
		
	
		$count = $this->tableModel->countBadges();
		
		$lastOffset = $count - $limit;
		
		if($offset < 0){
			$offset = 0;
		}
		
		if($offset > $lastOffset){
			$offset = $lastOffset;
		}

		$badges = $this->tableModel->getBadges((int)$limit, (int)$offset, (int)$category,(int)$order, 0);
		
		$catData = $this->tableModel->getBadgeCategories();
    
	  $data = [
		'limit' => $limit,
		'offset' => $offset,
		'lastOffset' => $lastOffset,
        'title' => 'View Badges',
		'badges'=> $badges,
		'categories' => $catData,
		"category" => $category,
		"order" => $order
      ];
      
	  $this->view('pages/viewBadges', $data);

	}
	
	public function viewBadgesAdmin($limit = 10, $offset = 0, $category = 0,$order = 0){
		
		$count = $this->tableModel->countBadges();
		
		$lastOffset = $count - $limit;
		
		if($offset < 0){
			$offset = 0;
		}
		
		if($offset > $lastOffset){
			$offset = $lastOffset;
		}

		$badges = $this->tableModel->getBadges((int)$limit, (int)$offset, (int)$category,(int)$order, 1);
		
		$catData = $this->tableModel->getBadgeCategories();
    
	  $data = [
		'limit' => $limit,
		'offset' => $offset,
		'lastOffset' => $lastOffset,
        'title' => 'View Badges (Admin)',
		'badges'=> $badges,
		'categories' => $catData,
		"category" => $category,
		"order" => $order
      ];
      
	  $this->view('pages/viewBadgesAdmin', $data);

	}

	public function logout (){

		$token = $_SESSION['token'];

		unset($_SESSION['username']);

		$this->tableModel->logout($token);

		redirect('pages/index');
	}
 
 }
