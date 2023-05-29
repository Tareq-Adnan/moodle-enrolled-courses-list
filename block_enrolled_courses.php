<?php
/**
 * @package     block_enrolled_courses
 * @copyright   2023 Tarekul Islam <tarekul.islam@brainstation-23.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

 //require_once('./lib.php');
class block_enrolled_courses extends block_base {

    public function init() {
        global $CFG;
        // Needed by Moodle to differentiate between blocks.
        $this->title = "";
    }

    function has_config() {
        return true;
    }

    public function get_content() {

        global $OUTPUT,$DB,$USER;
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();

        $sql="SELECT enrolid FROM {user_enrolments} WHERE userid = :id";
        $enrolid=$DB->get_records_sql($sql, ['id'=>$USER->id]);

        $course_id=[];
        foreach($enrolid as $k){
            $sql="SELECT courseid FROM {enrol} WHERE id = :id";
            $course_id[]=$DB->get_records_sql($sql, ['id'=>$k->enrolid]);
        }
      
        $courses=[];
        for($i=0;$i<count($course_id);$i++){
            $sql="SELECT id,fullname FROM {course} WHERE id = :id";
            $courses[]=$DB->get_records_sql($sql, ['id'=>array_values(array_values(array_values($course_id))[$i])[0]->courseid]);

        }
       
        echo "<pre>";
        //var_dump();
        echo "</pre>";
       
        $list="";

        $sql="SELECT c.id, c.fullname, ra.roleid
        FROM {course} AS c
        JOIN {context} AS ctx ON c.id = ctx.instanceid
        JOIN {role_assignments} AS ra ON ra.contextid = ctx.id
        JOIN {user} AS u ON u.id = ra.userid
        WHERE u.id = :id";
        $data=$DB->get_records_sql($sql, ['id'=>$USER->id]);

       //Role id 5 equal Students
        if(array_values($data)[0]->roleid==5){
            $list.="<h5>Enrolled Courses</h5>";
        for($i=0;$i<count($courses);$i++){
                $list.="<div class='d-flex border rounded px-1 my-1 justify-content-between align-items-center bh'>".array_values($courses[$i])[0]->fullname."";
                $list.="<a class='btn btn-sm text-sm btn-light p-2 d-inline  text-decoration-none rounded my-1 shadow-sm' href='/course/view.php?id=".array_values($courses[$i])[0]->id."'>Details</a>";
                $list.="</div>";
        
        }
    }
        //Role id 5 equal Editing Teachers
        if(array_values($data)[0]->roleid==3){
            $list.="<h5>My Courses</h5>";
       
            foreach($data as $d){
             $list.="<div class='d-flex border rounded px-1 my-1 justify-content-between align-items-center bh'>".$d->fullname."";
             $list.="<a class='btn btn-sm text-sm btn-light p-2 d-inline  text-decoration-none rounded my-1 shadow-sm' href='/course/view.php?id=".$d->id."'>Details</a>";
             $list.="</div>";
            }
        }

        
    //     for($i=0;$i<count($courses);$i++){
           
    
    // }
        // for($i=0;$i<count($courses);$i++){
        //     $list.="<a class='p-2  d-block text-decoration-none rounded my-1 shadow-sm' href='/course/view.php?id=".array_values($courses[$i])[0]->id."'>";
        //     $list.=array_values($courses[$i])[0]->fullname."<br>";
        //     $list.="</a>";
        
        // }
        $this->content->text=$list;
        return $this->content;
    }
   
    public function instance_allow_multiple() {
        return true;
    }

    
}
