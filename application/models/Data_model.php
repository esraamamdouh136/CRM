<?php
/**
 *
 */
class Data_model extends CI_Model {
	public function Add($data, $table) {
		$this->db->insert($table, $data);
		$LastID = $this->db->insert_id();
		return $LastID;
	}
	public function Update($data, $ID, $col, $table) {
		$this->db->where($col, $ID);
		$this->db->update($table, $data);
		return true;
	}
	public function UpdateWhere($data, $table, $array) {
		$this->db->update($table, $data, $array);
		return true;
	}
	public function Delete($ID, $col, $table) {
		$this->db->where($col, $ID);
		$this->db->delete($table);
		return true;
	}
	public function DeleteWhere($table, $array) {
		$this->db->delete($table, $array);
		return true;
	}
	public function SelectRow($sql, $array, $ResultType) {
		if ($array == '') {
			$query = $this->db->query($sql);
		} else {
			$query = $this->db->query($sql, $array);
		}
		if ($query->num_rows() > 0) {
			if ($ResultType == 'J') {
				$result = $query->row();
			} elseif ($ResultType == 'A') {
				$result = $query->row_array();
			}

		} else {
			$result = '0';
		}
		return $result;
	}
	public function Select($sql, $array, $ResultType) {
		if ($array == '') {
			$query = $this->db->query($sql);
		} else {
			$query = $this->db->query($sql, $array);
		}
		if ($query->num_rows() > 0) {
			if ($ResultType == 'J') {
				$result = $query->result();
			} elseif ($ResultType == 'A') {
				$result = $query->result_array();
			}
		} else {
			$result = '0';
		}
		return $result;
	}
	public function SendEmail($to, $subject, $massage) {
		$this->load->helper('email');
		if (valid_email($to)) {
			$headers = "From: info@LaVieEnRose.com";
			mail($to, $subject, $massage, $headers);
			return '1';
		} else {
			return '0';
		}
	}
	public function SendAndroidNoti($devicetoken, $msg) {

		define('API_ACCESS_KEY', 'YOUR-API-ACCESS-KEY-GOES-HERE');
		$msg = array
			(
			'message' => $msg,
			'title' => 'This is a title. title',
			'subtitle' => 'This is a subtitle. subtitle',
			'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate' => 1,
			'sound' => 1,
			'largeIcon' => 'large_icon',
			'smallIcon' => 'small_icon',
		);
		$fields = array
			(
			'registration_ids' => $devicetoken,
			'data' => $msg,
		);

		$headers = array
			(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		curl_close($ch);
		//echo $result;
	}
	private function SendIosNoti($deviceToken, $message) {

		$passphrase = 'myPrivateKey';
		$badge = 1;
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp) {
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		}

		echo 'Connected to APNS' . PHP_EOL;

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'badge' => $badge,
			'sound' => 'newMessage.wav',
		);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		if (!$result) {
			echo 'Error, notification not sent' . PHP_EOL;
		} else {
			echo 'notification sent!' . PHP_EOL;
		}

		// Close the connection to the server
		fclose($fp);
	}
	public function SendNoti($fields) {

		$url = 'https://fcm.googleapis.com/fcm/send';
		$key = "AAAA5v9oOP8:APA91bHV7ESYqcD-TYw43QoQnPrFqx-Ax6lIFkcoZw4tK5pe8lLGLUfExskG_dZU-FfEnAF0X817TDZ9WKxRGDQ7yXqNC2Tjt4RZCMzkhsvfTaV2asS5026gSCewl_JTlJiticGz6oc9";
		//define( 'API_ACCESS_KEY', '697147440823' );
		$headers = array
			(
			'Authorization: key=' . $key,
			'Content-Type: application/json',
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		if ($result === False) {
			die('Curl Filed ' . curl_errno($ch));
		}
		curl_close($ch);
		return $result;
	}
	function sendOneSingle($arr,$users){
    $content = array(
				"en" => 'khodrwaty',
        "ar" => 'خضرواتى ',
        );

    $fields = array(
			'app_id' => "1ff43093-4c7b-4edf-b383-020660553fd1",
			'include_player_ids' => $users,
			'data' => $arr,
			'contents' => $content
    );

		$fields = json_encode($fields);
		// print("\nJSON sent:\n");
		// print($fields);

		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
		                                               'Authorization: Basic MTA3NDhiMTYtZTkzYi00YjFiLTgxMDAtODQzZWYxYTQ3Nzg1'));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		    curl_setopt($ch, CURLOPT_HEADER, FALSE);
		    curl_setopt($ch, CURLOPT_POST, TRUE);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		    $response = curl_exec($ch);
		    curl_close($ch);

		    return $response;
		}
		function sendAllSingle($arr){
			$content = array(
					"en" => 'khodrwaty',
					"ar" => 'خضرواتى ',
					);

			$fields = array(
				'app_id' => "1ff43093-4c7b-4edf-b383-020660553fd1",
				'included_segments' => array("All"),
				'data' => $arr,
				'contents' => $content
			);

			$fields = json_encode($fields);
			// print("\nJSON sent:\n");
			// print($fields);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
																										 'Authorization: Basic MTA3NDhiMTYtZTkzYi00YjFiLTgxMDAtODQzZWYxYTQ3Nzg1'));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					curl_setopt($ch, CURLOPT_HEADER, FALSE);
					curl_setopt($ch, CURLOPT_POST, TRUE);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

					$response = curl_exec($ch);
					curl_close($ch);

					return $response;
			}
	public function UploadImage($file, $img_name) {
		
		if (empty($_FILES[$file]['name'])) {
			$imgUrl = '';
		} else {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = '*';
			$config['file_name'] = $img_name;
			$config['overwrite'] = True;
			// $config['max_size']             = 1024;
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;
			$this->load->library('upload', $config);
			$this->upload->do_upload($file);
			$data[$file] = $this->upload->data();
			// $imgUrl = base_url() . 'uploads/' . $data[$file]['file_name'];
			$imgUrl = $data[$file]['file_name'];
			// echo $this->upload->display_errors();die();
			$relativePath = "./uploads/" . $data[$file]['file_name'] . "";
			// $this->ResizeImage($relativePath);
		}
		return $imgUrl;
	}
	public function UploadImage2($file, $img_name) {
		if (empty($_FILES[$file]['name'])) {
			$imgUrl = '';
		} else {
			$config['upload_path'] = './uploads/Small/';
			$config['allowed_types'] = '*';
			$config['file_name'] = $img_name;
			$config['overwrite'] = True;
			// $config['max_size']             = 1024;
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;
			$this->load->library('upload', $config);
			$this->upload->do_upload($file);
			$data[$file] = $this->upload->data();
			// $imgUrl = base_url() . 'uploads/' . $data[$file]['file_name'];
			$imgUrl = $data[$file]['file_name'];
			// echo $this->upload->display_errors();die();
			$relativePath = "./uploads/Small/" . $data[$file]['file_name'] . "";
			$this->ResizeImage($relativePath);
		}
		return $imgUrl;
	}
	public function img_decoder($encoded_string, $path) {
		$image_name = time() . uniqid(rand()) . '.jpg';
		$new_path = FCPATH . 'uploads/' . $image_name;
		$hashdata = array(" ");
		$with = "+";
		$imageDataEncoded = str_replace($hashdata, $with, $encoded_string);
		$decoded_string = base64_decode($imageDataEncoded);
		$photo = imagecreatefromstring($decoded_string);
		if ($photo !== false) {
			//$rotate = imagerotate($photo, 90, 0);
			imagejpeg($photo, $new_path, 100);
			imagedestroy($photo);
			$this->img_decoder2($encoded_string, $path,$image_name);
			return $image_name;
		}
	}
	public function img_decoder2($encoded_string, $path,$image_name) {
		$new_path = FCPATH . 'uploads/Small/' . $image_name;
		$hashdata = array(" ");
		$with = "+";
		$imageDataEncoded = str_replace($hashdata, $with, $encoded_string);
		$decoded_string = base64_decode($imageDataEncoded);
		$photo = imagecreatefromstring($decoded_string);
		if ($photo !== false) {
			//$rotate = imagerotate($photo, 90, 0);
			imagejpeg($photo, $new_path, 100);
			imagedestroy($photo);
			return true;
		}
	}
	public function ResizeImage($URL) {
		$this->load->library('image_lib');
		$config['image_library'] = 'gd2';
		$config['source_image'] = $URL;
		$config['create_thumb'] = False;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 400;
		$config['height'] = 300;

		$this->load->library('image_lib', $config);

		$this->image_lib->clear();
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		echo $this->image_lib->display_errors('<p>', '</p>');
	}

	function do_upload($file,$img_name) {
		if (empty($_FILES[$file]['name'])) {
			return '';
		}
				$config['image_library'] = 'gd2';
        $original_path = './uploads/';
        $resized_path = './uploads/Small';
        // $thumbs_path = './uploads/activity_images/thumb';
        $this->load->library('image_lib');

        $config = array(
            'allowed_types' => '*', //only accept these file types
            'max_size' => 2048, //2MB max
            'upload_path' => $original_path, //upload directory
					  'file_name' => $img_name,
						'overwrite' => True
        );
        $this->load->library('upload', $config);
        $this->upload->do_upload($file);
        $image_data = $this->upload->data(); //upload the image
        $image1 = $image_data['file_name'];

        //your desired config for the resize() function
        $config = array(
            'source_image' => $image_data['full_path'], //path to the uploaded image
            'new_image' => $resized_path,
            'maintain_ratio' => true,
            'width' => 128,
            'height' => 128
        );
        $this->image_lib->initialize($config);
        $this->image_lib->resize();

        // for the Thumbnail image
        // $config = array(
        //     'source_image' => $image_data['full_path'],
        //     'new_image' => $thumbs_path,
        //     'maintain_ratio' => true,
        //     'width' => 36,
        //     'height' => 36
        // );
        //here is the second thumbnail, notice the call for the initialize() function again
        // $this->image_lib->initialize($config);
        //
        // $this->image_lib->resize();
        //$this->image_lib->clear();
       // echo  $this->image_lib->display_errors();
       //  var_dump(gd_info());
       //  die();
        return $image1;
    }
	//to get distance beetwen two point in maps

	public function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
		cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		return ($miles * 1.609344);
	}
	public function random($length = 8) {
		$chars = 'bcdf3423gh2124jklmnprstvwxz4476422981323aeiou';
		$result = '';
		for ($p = 0; $p < $length; $p++) {
			$result .= ($p % 2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
		}

		return $result;
	}
	public function msort($array, $key, $sort_flags = SORT_REGULAR, $order = SORT_DESC) {
		if (is_array($array) && count($array) > 0) {
			if (!empty($key)) {
				$mapping = array();
				foreach ($array as $k => $v) {
					$sort_key = '';
					if (!is_array($key)) {
						$sort_key = $v[$key];
					} else {
						// @TODO This should be fixed, now it will be sorted as string
						foreach ($key as $key_key) {
							$sort_key .= $v[$key_key];
						}
						$sort_flags = SORT_STRING;
					}
					$mapping[$k] = $sort_key;
				}
				switch ($order) {
				case SORT_ASC:
					asort($mapping, $sort_flags);
					break;
				case SORT_DESC:
					arsort($mapping, $sort_flags);
					break;
				}
				$sorted = array();
				foreach ($mapping as $k => $v) {
					$sorted[] = $array[$k];
				}
				return $sorted;
			}
		}
		return $array;
	}
	public function DeleteImage($imagePath) {
		$CutPath = 'meahny/';
		$path3 = substr($imagePath, strpos($imagePath, $CutPath) + strlen($CutPath));
		$path = __dir__ . '/' . $path3;
		$path2 = str_replace('\application\models', '/', $path);
		unlink($path2);
		return True;
	}
	public function getYoutubeEmbedUrl($url){
	    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
	    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

	    if (preg_match($longUrlRegex, $url, $matches)) {
	        $youtube_id = $matches[count($matches) - 1];
	    }

	    if (preg_match($shortUrlRegex, $url, $matches)) {
	        $youtube_id = $matches[count($matches) - 1];
	    }
	    return 'https://www.youtube.com/embed/' . $youtube_id ;
	}
	public function Get_Address_From_Google_Maps($lat, $lon) {
	  $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";
	  $data = @file_get_contents($url);
	  $jsondata = json_decode($data,true);
	  if ($jsondata["status"] != "OK")   return array();
	  $short_name = false;
	    $array=$jsondata["results"][0]["address_components"];
	    foreach( $array as $value) {
	        if (in_array("locality", $value["types"])) {
	            if ($short_name)
	                return $value["short_name"];
	            return $value["long_name"];
	        }
	    }
	}
	// public function msort($array, $key, $sort_flags = SORT_REGULAR,$order = SORT_DESC) {
	//    	if (is_array($array) && count($array) > 0) {
	//        if (!empty($key)) {
	//            $mapping = array();
	//            foreach ($array as $k => $v) {
	//                $sort_key = '';
	//                if (!is_array($key)) {
	//                    $sort_key = $v[$key];
	//                } else {
	//                    // @TODO This should be fixed, now it will be sorted as string
	//                    foreach ($key as $key_key) {
	//                        $sort_key .= $v[$key_key];
	//                    }
	//                    $sort_flags = SORT_STRING;
	//                }
	//                $mapping[$k] = $sort_key;
	//            }
	//            switch ($order) {
	// 		case SORT_ASC:
	// 		asort($mapping, $sort_flags);
	// 		break;
	// 		case SORT_DESC:
	// 		arsort($mapping, $sort_flags);
	// 		break;
	// 		}
	//            $sorted = array();
	//            foreach ($mapping as $k => $v) {
	//                $sorted[] = $array[$k];
	//            }
	//            return $sorted;
	//        }
	//   	 }
	//    	return $array;
	// }

}
?>
