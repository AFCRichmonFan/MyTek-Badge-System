requirements<?php
	class Table {
		private $db;

		public function __construct(){
			$this->db = new Database;
		}

        //return row counts
        public function countRecords($table,$sql_addon = null,$bind_values = null) {
            $this->db->query("SELECT count(*) AS total FROM $table
                                       $sql_addon");

            if (isset($bind_values)) {
                foreach ($bind_values as $value) {
                    $this->db->bind($value['bind_name'],$value['bind_value']);
                }
            }

            return $this->db->single()->total;
        }

		public function login($username, $password) {
			$this->db->query("SELECT username FROM login WHERE username = :username and password = :password");
			
			$this->db->bind(":username" , $username);
			$this->db->bind(":password" , $password);

			return $this->db->resultSet();
		}

		public function auth ($token){
			$this->db->query("SELECT username, login_id, acessLevel FROM login WHERE token = :token");
			
			$this->db->bind(":token" , $token);
			
			return $this->db->resultSet();
			
		}

		public function getBadgeCategories(){
			$this->db->query("SELECT * FROM badge_category");
			
			return $this->db->resultSet();
		}

		public function awardBadge($badge_id, $login_id){
			$this->db->query("INSERT INTO `badge_login` (`badge_id`, `login_id`) VALUES (:badge_id, :login_id)");

			$this->db->bind(":badge_id" , $badge_id);
			$this->db->bind(":login_id" , $login_id);
								    
			$this->db->execute();

			//part 2

			$this->db->query("UPDATE `badge` SET `amount_earned` = `amount_earned` + 1 WHERE `badge`.`badge_id` = :badge_id");
			
			$this->db->bind(":badge_id" , $badge_id);
			
			$this->db->execute();
			
		}

		public function genNewToken ($username){

			$newToken = bin2hex(random_bytes(32));

			$this->db->query("UPDATE `login` SET `token` = '$newToken' WHERE `username` = :username;");
			
			$this->db->bind(":username" , $username);
								    $this->db->execute();
			
			return $newToken;
		}

		public function editBadge ($id,$name,$description,$req,$link,$category,$hidden){
			
			$this->db->query("UPDATE `badge` SET `name` = :name, `description` = :description, `requirements` = :requirements, `img` = :link, `hidden` = :hidden, `badge_category_id` = :category WHERE `badge`.`badge_id` = :id");
					    

						$this->db->bind(":id", $id);
						$this->db->bind(":name", $name);
						    $this->db->bind(":description", $description);
						    $this->db->bind(":requirements", $req);
							    $this->db->bind(":link", $link);
							    $this->db->bind(":category", $category);
							    $this->db->bind(":hidden", $hidden);

								    

									$this->db->execute();

									return $id;

			
		}

		public function getBadgeData($id){
			$this->db->query("SELECT * FROM badge INNER JOIN badge_category ON badge_category.badge_category_id = badge.badge_category_id WHERE badge.badge_id = :id");

			$this->db->bind(":id" , $id);
			
			return $this->db->resultSet();
			
		}

		public function logout($token){
			$this->db->query("UPDATE login SET token = '' WHERE token = :token;");
			
			$this->db->bind(":token" , $token);
								    $this->db->execute();

			return "done";
		}

			public function addBadge( $id,$name,$description,$req,$link,$category,$hidden){
			    // Insert the new badge into the database
				    $this->db->query("INSERT INTO badge (name, description, requirements, login_id, img, badge_category_id, hidden, created) VALUES (:name, :description, :req, :id, :link, :category, :hidden, NOW())");
						
						$this->db->bind(":id", $id);
						$this->db->bind(":name", $name);
						    $this->db->bind(":description", $description);
						    $this->db->bind(":req", $req);
							    $this->db->bind(":link", $link);
							    $this->db->bind(":category", $category);
							    $this->db->bind(":hidden", $hidden);
								    $this->db->execute();

													    // Return the ID of the new badge
														    return $id;
															}
public function getBadges($limit, $offset,$category = 0, $order = 0, $hidden = 0){

			$orderTypes = [
				'created',
				'name',
				'amount_earned',
			];

			$addon = "AND `badge_category_id` = :category";

			if($category == 0){
				$addon = "";
			}

		    // Retrieve the badges with the specified limit and offset
			    $this->db->query("SELECT * FROM badge WHERE `hidden` <= :hidden $addon ORDER BY ".$orderTypes[$order]." LIMIT :limit OFFSET :offset");
				    $this->db->bind(":limit" , $limit);
					    $this->db->bind(":offset" , $offset);
							$this->db->bind(":hidden" , $hidden);
					    

						if($category != 0){
							$this->db->bind(":category" , $category);
						}
						    $badges = $this->db->resultSet();

							    // Return an array with both the count and the badges
			   return $badges;
			}

			public function countBadges(){

				$this->db->query("SELECT COUNT(*) as total FROM badge");

				return $this->db->single()->total;
			}

	}
