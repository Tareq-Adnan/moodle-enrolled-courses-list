<?php
/**
 * @package     block_enrolled_courses
 * @copyright   2023 Tarekul Islam <tarekul.islam@brainstation-23.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_enrolled_courses extends block_base {

    public function init() {
        global $CFG;
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_enrolled_courses');
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
        
        for($i=0;$i<count($courses);$i++){
                $list.="<div class='d-flex border rounded px-1 my-1 justify-content-between align-items-center bh'>".array_values($courses[$i])[0]->fullname."";
                $list.="<a class='btn btn-sm text-sm btn-light p-2 d-inline  text-decoration-none rounded my-1 shadow-sm' href='/course/view.php?id=".array_values($courses[$i])[0]->id."'>Details</a>";
                $list.="</div>";
        
        }
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
