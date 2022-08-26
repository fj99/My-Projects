<!-- Example of controller in CI4 -->
<?php
namespace App\Controllers;
use App\Models\MyStudents;
use CodeIgniter\Config\Config;
use CodeIgniter\Controller;
class Students extends Controller
{

   public function index()
   {
      $session = \Config\Services::session();
      $message = $session->getFlashdata('message');
      $std = new MyStudents(); 
      $data['students'] = $std->findAll(); 
      $pager = \Config\Services::pager(); 
      $data['message'] = $message;
      echo view('students',$data);

      //var_dump($results);
      //echo 'index Students';
   }

   public function newstudent()
   {
      echo view('newstudent');
      //echo ' new method';
   }

   public function addstudent()
   {
      $request = \Config\Services::request();
      $session = \Config\Services::session();
      $name  = $request->getPost('std');
      $subject  = $request->getPost('subject');
      $newStudent = [
         's_name'=>$name,
         's_subject'=>$subject,
      ];
      $std = new MyStudents();
      $result = $std->insert($newStudent);
      if ($result) {
         $session->setFlashdata('message','You have successfully inserted the student.');
      }
      else{
         $session->setFlashdata('message','Oops something went wrong please try again.');
      }
      return redirect()->to(site_url('students'));
      //var_dump($result);
      //echo 'working..';
   }

   public function editstudent($userId =  null)
   {
      $session = \Config\Services::session();
      if (!empty($userId)) {
         $std = new MyStudents();
         $result = $std->where('s_id',$userId)->findAll();
         if (count($result) > 0) {
            $data['student'] = $result;
            echo view('editStudent',$data);
         }
         else{
            $session->setFlashdata('message','The Student is not exist');
            return redirect()->to(site_url('students'));
         }
      }
      else{
         $session->setFlashdata('message','The id is not available, please try again.');
         return redirect()->to(site_url('students'));
      }

   }

   public function updatestudent()
   {
      $request = \Config\Services::request();
      $session = \Config\Services::session();
      $name  = $request->getPost('std');
      $subject  = $request->getPost('subject');
      $studentId  = $request->getPost('id');

      $updateStudent = [
         's_name'=>$name,
         's_subject'=>$subject,
      ];
      //echo $studentId;
      //die();
      $std = new MyStudents();
      $result = $std->update($studentId,$updateStudent);
      if ($result) {
         $session->setFlashdata('message','You have successfully updated the student.');
      }
      else{
         $session->setFlashdata('message','Oops something went wrong please try again.');
      }
      return redirect()->to(site_url('students'));
   }

   public function delete($userId)
   {
      $session = \Config\Services::session();
      if (!empty($userId)) {
         $std = new MyStudents();
         $result = $std->where('s_id',$userId)->findAll();
         if (count($result) > 0) {
            //$result = $std->delete($userId);
            $result = $std->where('s_id',$userId)->delete();
            if ($result){
               $session->setFlashdata('message','You have successfully deleted.');
               return redirect()->to(site_url('students'));
            }
            else{
               $session->setFlashdata('message','You can\'t delete the student right now.');
               return redirect()->to(site_url('students'));
            }
         }
         else{
            $session->setFlashdata('message','The Student is not exist');
            return redirect()->to(site_url('students'));
         }
      }
      else{
         $session->setFlashdata('message','The id is not available, please try again.');
         return redirect()->to(site_url('students'));
      }
   }
}//class