<?php
	class Model1 extends CI_Model
	{
		public function selectdata($table, $where = null, $like = null) {


	        if ($where!=null ) {
	        	$this->db->where($where);
	        }

	        if ($like != null) {
	        	$this->db->LIKE($like);
	        }

	        $select = $this->db->get($table);

	        if ($this->db->affected_rows() == 0)
	            return null;

	        else
	            return $select->result();

	    }

	    public function getjoin($table1, $table2 , $ondata , $where = null)
	    {
			$this->db->from($table1);
			$this->db->join($table2, $ondata);


			if ($where!=null ) {
	        	$this->db->where($where);
	        }

			$select = $this->db->get();

			if ($this->db->affected_rows() == 0)
	            return null;

	        else
	            return $select->result();
	    }
        public function getjoin3table($table1, $table2 ,$table3, $ondata , $ondata1 , $where = null)
        {
            $this->db->from($table1);
            $this->db->join($table2, $ondata);
            $this->db->join($table3, $ondata1);

            if ($where!=null ) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();
        }

	    public function updatedata($table, $where = null,$values= array()) {


	        if ($where!=null ) {
	        	$this->db->where($where);
	        }

	        $update = $this->db->update($table , $values);

	        if (!$update)
	            return "ERROR";

	        else
	            return "DONE";

	    }

	    public function addtotable($table, $values = array()) {

	        $Qinsert = $this->db->insert($table , $values);
	        $lastinsert =  $this->db->insert_id();
	        if ($this->db->affected_rows() == 0)
	            return "ERROR";

	        else
	            return $lastinsert;

	    }

	    public function removefromtable($table,$where = array()) {
	    	if ($where != null) {
	    		$this->db->where($where);
	    	}

	        $Qinsert = $this->db->delete($table);

	        if ($this->db->affected_rows() == 0)
	            return "ERROR";

	        else
	            return "DONE";

		}
		public function get_three_join($tablefrom,$table1,$table2,$ondata1,$ondata2, $where=null)
        {


            $this->db->select("*");

            $this->db->from($tablefrom);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);


            if ($where!=null ) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();

        }

/*Mahmoud Ahmed */
	    public function get_more_join($selectInfo,$tablefrom,$table1,$table2,$table3,$table4,$table5,$table6,$ondata1,$ondata2,$ondata3,$ondata4,$ondata5,$ondata6, $where=null)
        {


            $this->db->select($selectInfo);

            $this->db->from($tablefrom);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);
            $this->db->join($table3, $ondata3);
            $this->db->join($table4, $ondata4);
            $this->db->join($table5, $ondata5);
            $this->db->join($table6, $ondata6);

            if ($where!=null ) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();

        }

      public function static_query()
        {
			$this->db->select("Class_Information.course_name, Class_Information.courses_id ,
							   Class_Information.group_name,Class_Information.groups_id ,Class_Information.class_number,
							   Class_Information.classes_id ,Class_Information.coach_id ,Class_Information.coach_name , 
							   Class_Information.admin_id ,Class_Information.admin_name ,Class_Information.pool_name, 
							   Class_Information.class_date , Class_Information.Trainne_count,attendance.class_attent");
            $query=$this->db->get("(SELECT courses.name as course_name, courses.id As courses_id , groups.name as group_name, groups.id AS groups_id ,
									classes.class_number as class_number, classes.id AS classes_id ,groups.coach_id as coach_id ,
									coach.name As coach_name , groups.admin_id As admin_id ,admin.name AS admin_name ,
									pool.name as pool_name, classes.class_date as class_date , COUNT(group_trainee.id) AS Trainne_count
									FROM groups
										JOIN classes
											ON groups.id=classes.group_id
										JOIN courses
											ON groups.course_id=courses.id
										JOIN group_trainee
										  ON group_trainee.group_id = groups.id
										JOIN pool
											ON  groups.pool_id=pool.id
										JOIN users admin 
										  ON admin.id = groups.admin_id
										JOIN users coach 
										  ON coach.id = groups.coach_id
										GROUP by classes.id) Class_Information
									LEFT JOIN ( SELECT classes.id AS classes_id ,COUNT(class_info.id) AS class_attent
									FROM classes
									JOIN class_info ON classes.id = class_info.class_id
									WHERE class_info.attend = 1
									GROUP by classes.id) attendance
									on attendance.classes_id = Class_Information.classes_id");
            return $query->result();

        }
        public function payment_details_model()
        {
            $this->db->select("course_trainee.group_id,
								course_trainee.group_name,
								course_trainee.course_name,
								course_trainee.course_id,
								course_trainee.start_date,
								course_trainee.end_date,
								group_count.group_trainee_count,
								COUNT(payment.id) AS payment_count");
            $query=$this->db->get("(SELECT
										groups.id AS group_id,
										groups.name AS group_name,
										courses.name AS course_name,
										courses.id AS course_id,
										courses.start_date AS start_date,
										courses.end_date AS end_date,
										group_trainee.trainee_id AS trainee_id
									FROM
										groups
									LEFT JOIN group_trainee ON groups.id = group_trainee.group_id
									JOIN courses ON courses.id = groups.course_id
									) course_trainee
								LEFT JOIN(
									SELECT
										groups.id AS group_id,
										COUNT(group_trainee.id) AS group_trainee_count
									FROM
										groups
									LEFT JOIN group_trainee ON groups.id = group_trainee.group_id
									GROUP BY
										groups.id
									) group_count
								  ON group_count.group_id = course_trainee.group_id
								LEFT JOIN payment 
								  ON payment.trainee_id = course_trainee.trainee_id 
									 AND course_trainee.course_id = payment.course_id AND payment.status = 1
								GROUP BY
									 course_trainee.group_id");

            return $query->result();
        }

        public function person_attend($where = null)
        {
			if ($where != null) {
                $this->db->where($where);
            }

            $query = $this->db->get("(SELECT classes.class_date as class_Date, classes.class_number as class_name, courses.name as course_name, classes.id as class_id, groups.admin_id as admin_Id, groups.coach_id as coach_Id
      FROM groups
      JOIN courses
      ON groups.course_id=courses.id
      JOIN classes
      ON groups.id=classes.group_id
     )class_details
     JOIN class_info
     ON class_details.class_id=class_info.class_id");


            return $query->result();
        }

        public function finished_courses_Model($select_info, $from_table, $table1, $table2, $table3, $ondata1, $ondata2, $ondata3, $where = null)
        {
            $this->db->select($select_info);

            $this->db->from($from_table);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);
            $this->db->join($table3, $ondata3);

            if ($where != null) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();

        }

        public function class_attend_modell($where = null)
        {
            $this->db->select("classes_Details.class_id , classes_Details.class_name , 
      classes_Details.class_date , classes_Details.class_note ,classes_Details.total_trainee , COUNT(class_info.id) As Attended_trainee");
			if ($where != null) {
                $this->db->where($where);
            }
            $this->db->group_by("classes_Details.class_id");
            $query = $this->db->get("(SELECT classes.id AS class_id , classes.class_number as class_name , classes.class_notes AS class_note, classes.group_id as group_id ,
      classes.class_date as class_date , COUNT(group_trainee.id) as total_trainee
      FROM classes
        JOIN group_trainee
	      ON classes.group_id = group_trainee.group_id
      GROUP BY classes.id) classes_Details
 LEFT JOIN class_info
  	ON class_info.class_id = classes_Details.class_id AND class_info.attend = 1");
            return $query->result();
        }



        public function finished_groups_modell($where = null)
        {
			if ($where != null) {
                $this->db->where($where);
            }

			$this->db->group_by("group_id");

            $query = $this->db->get("(SELECT courses.name as course_name, courses.id as course_ID ,groups.id as groups_ID,
										classes.id as classe_ID, groups.name as group_name, groups.admin_id as admin_id , 
										groups.coach_id as coach_id ,pool.name as pool_name, classes.class_number as class_name, 
										classes.class_date as class_Date , courses.no_of_classes as Num_classes
										FROM groups 
										JOIN courses
										ON groups.course_id=courses.id
										JOIN classes
										ON groups.id=classes.group_id
										JOIN pool
										ON groups.pool_id=pool.id)group_details
									JOIN  (SELECT groups.id AS group_id , groups.name AS group_name , COUNT(classes.id) AS num_finished_classes
											FROM groups
											LEFT JOIN classes
											on groups.id = classes.group_id AND classes.status = 4
											GROUP BY groups.id) finish_class
									on group_details.groups_ID = finish_class.group_id  
										AND group_details.Num_classes = finish_class.num_finished_classes");
            return $query->result();

        }


		public function finished_classes_modell($where = null)
        {
			if ($where != null) {
                $this->db->where($where);
            }

			$query = $this->db->get("(SELECT courses.name as course_name, courses.id as course_id ,groups.id as group_id, groups.name as group_name, groups.admin_id as admin_id , 
										groups.coach_id as coach_id ,pool.name as pool_name,classes.id as class_id,classes.class_number as class_name, 
										classes.class_date as class_Date ,classes.class_notes AS class_note ,courses.no_of_classes as Num_classes
										FROM groups 
										JOIN courses
										ON groups.course_id=courses.id
										JOIN classes
										ON groups.id=classes.group_id
										JOIN pool
										ON groups.pool_id=pool.id)group_details
									JOIN (SELECT groups.id AS group_id , groups.name AS group_name , COUNT(classes.id) AS num_finished_classes
											FROM groups
											LEFT JOIN classes
											on groups.id = classes.group_id AND classes.status = 4
											GROUP BY groups.id) finish_class
									on group_details.group_id = finish_class.group_id  
										AND finish_class.num_finished_classes <> 0 
										AND group_details.Num_classes <> finish_class.num_finished_classes");
			return $query->result();
		}


		public function trainee_attendance_modell($select_info, $from_table, $table1, $table2,$ondata1, $ondata2, $where = null)
        {
            $this->db->select($select_info);

            $this->db->from($from_table);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);

            if ($where != null) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;
            else
                return $select->result();

        }
        public function joindata_groupby($select , $table1 , $table2 , $ondata ,$where = null, $groupby )
        {
            $this->db->select($select);
            $this->db->from($table1);
            $this->db->join($table2, $ondata);

            if ($where != null) {
                $this->db->where($where);
            }

			$this->db->group_by($groupby);

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();
        }

		 public function double_joindata($selectInfo, $tablefrom, $table1, $table2 , $ondata1, $ondata2 , $where = null)
        {


            $this->db->select($selectInfo);

            $this->db->from($tablefrom);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);

            if ($where != null) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();

        }

		public function Show_classes_Model($select_info, $from_table, $table1, $table2, $table3, $table4, $ondata1, $ondata2, $ondata3, $ondata4, $where = null)
        {
            $this->db->select($select_info);

            $this->db->from($from_table);
            $this->db->join($table1, $ondata1);
            $this->db->join($table2, $ondata2);
            $this->db->join($table3, $ondata3);
			$this->db->join($table4, $ondata4);

            if ($where != null) {
                $this->db->where($where);
            }

            $select = $this->db->get();

            if ($this->db->affected_rows() == 0)
                return null;

            else
                return $select->result();

        }

		/**** Bassam Edits ***/
		// users Token to make a notification event
        public function getTraineesToken($group_id)
        {
        	$select = $this->db->query("SELECT users.token AS user_token
									    FROM users
									      JOIN group_trainee
									    	ON group_trainee.trainee_id = users.id
										WHERE users.token <> '' 
											  AND users.active = 1 
											  AND group_trainee.group_id =".$group_id);

    		return $select->result();
        }


        public function getStaffToken($group_id)
        {
        	$select = $this->db->query("SELECT users.token AS user_token
										    FROM users
										      JOIN groups
										    	ON groups.coach_id = users.id
										    WHERE users.token <> '' 
											  AND users.active = 1 
											  AND groups.id = ".$group_id."
										UNION
										    SELECT users.token AS user_token
										    FROM users
										    WHERE users.token <> '' 
											  AND users.active = 1 
											  AND users.type = 3");

    		return $select->result();
        }

        public function getManagersToken()
        {
        	$select = $this->db->query("SELECT users.token AS user_token
									    FROM users
									    WHERE users.token <> '' 
											  AND users.active = 1 
											  AND users.type = 3");

    		return $select->result();
        }

        public function getSingleUserToken($user_id)
        {
        	$select = $this->db->query("SELECT users.token AS user_token
									    FROM users
									    WHERE users.token <> '' 
											  AND users.active = 1 
											  AND users.id = ".$user_id);

    		return $select->result();
        }

        // users id to add notification to notifications table

        public function getTraineesID($group_id)
        {
        	$select = $this->db->query("SELECT users.id AS user_id
									    FROM users
									      JOIN group_trainee
									    	ON group_trainee.trainee_id = users.id
										WHERE group_trainee.group_id =".$group_id);

    		return $select->result();
        }


        public function getStaffID($group_id)
        {
        	$select = $this->db->query("SELECT users.id AS user_id
										    FROM users
										      JOIN groups
										    	ON groups.coach_id = users.id
										    WHERE groups.id = ".$group_id."
										UNION
										    SELECT users.id AS user_id
										    FROM users
										    WHERE users.type = 3");

    		return $select->result();
        }

        public function getManagersID()
        {
        	$select = $this->db->query("SELECT users.id AS user_id
									    FROM users
									    WHERE users.type = 3");

    		return $select->result();
        }


        // notification table retreive

        public function getNotications($select , $tablefrom , $table1 , $table2 , $ondata1 , $ondata2 ,$where = null)
        {
        	$this->db->select($select);
			$this->db->from($tablefrom);
			$this->db->join($table1, $ondata1);
			$this->db->join($table2, $ondata2);

			if ($where != null) {
                $this->db->where($where);
            }

			$select = $this->db->get();

			if ($this->db->affected_rows() == 0)
	            return null;

	        else
	            return $select->result();
        }


        public function getNoticationsCount($user_id)
        {
        	$select = $this->db->query("SELECT notification.to_id , COUNT(notification.id) AS counter
										FROM notification
										WHERE notification.notify_read = 0 AND notification.to_id = ".$user_id);

    		return $select->result();
        }

        public function selectClassForNotify($where = null)
        {
        	$table1 = "classes";
        	$table2 = "(SELECT courses.id AS course_id , courses.name AS course_name, 
					      groups.id AS group_id , groups.name AS group_name
					      FROM groups
					      JOIN courses
							ON courses.id = groups.course_id) group_info";
			$ondata = "ON classes.group_id = group_info.group_id";
	        if ($where!=null ) {
	        	$this->db->where($where);
	        }

	        $this->db->select("*");
	        $this->db->from($table1);
            $this->db->join($table2, $ondata);
	        $select = $this->db->get();

	        if ($this->db->affected_rows() == 0)
	            return null;

	        else
	            return $select->result();

	    }

	}
?>