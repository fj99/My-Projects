<div class="container">
   <div class="welcome_header">
   </div>
   <div class="staff_portal_information">
   </div>

   <div class="container_one_row">
      <div class="update_container">
         <?php
         $staff_data = $search["staff_portal"]->getRow();
         $users_data = $search['program_portal']->getRow();
         $auth_data = $search['staff_admin_portal']->getRow();

         if ($search['permissions'] != null) {
            $resworkorder = $search['permissions']->getRow();
         } else {
            $resworkorder = false;
         }
         if ($search['permissions'] != null) {
            $reslife_pdsadm = $search['permissions']->getRow();
         } else {
            $reslife_pdsadm = false;
         }
         if ($search['permissions'] != null) {
            $tutorctr = $search['permissions']->getRow();
         } else {
            $tutorctr = false;
         }
         ?>
         <h2>Update <?php echo $auth_data->name_first . " " . $auth_data->name_last . " <br>" . $auth_data->id . ", " . $auth_data->user . "" ?></h2>
         </body>

         <body onload="createReadableDataFields();">
            <form method="POST" action="submitUpdate">
               <input type="text" name="user_id" value="<?php echo $staff_data->id ?>" hidden>
               <input type="text" name="username" value="<?php echo $staff_data->username ?>" hidden>
               <input type="text" name="fname" value="<?php echo $staff_data->first_name ?>" hidden>
               <input type="text" name="lname" value="<?php echo $staff_data->last_name ?>" hidden>
               <div class="simple_update_container">
                  <h3>Simple Update</h3>
                  <table class="app_table">
                     <tr>
                        <th>Hall</th>
                        <th>Job</th>
                        <th>Active</th>
                        <th>SAP Access</th>
                     </tr>
                     <tr>
                        <td>
                           <!-- //* New halls -->
                           <select id="sap_hall" name="sap_hall">
                              <option value=1>Brownell</option>
                              <option value=2>Chase</option>
                              <option value=3>Farnham</option>
                              <option value=4>Hickerson</option>
                              <option value=5>Neff</option>
                              <option value=6>North</option>
                              <option value=7>Schwartz</option>
                              <option value=8>West</option>
                              <option value=9>Wilkinson</option>
                              <option value=10>North Campus Midrise</option>
                              <option value=11>North Campus Townhouses</option>
                           </select>
                        </td>
                        <td>
                           <select name="sap_job" id="sap_job">
                              <option id="sap_job_1" value="1">
                                 Director of Housing
                              </option>
                              <option id="sap_job_2" value="2">
                                 Director of Operations
                              </option>
                              <option id="sap_job_3" value="3">
                                 Director of Education & Community
                              </option>
                              <option id="sap_job_4" value="4">
                                 IT Coordinator
                              </option>
                              <option id="sap_job_5" value="5">
                                 Directors Assistant
                              </option>
                              <option id="sap_job_6" value="6">
                                 Director of Upper-Class Communities
                              </option>
                              <option id="sap_job_7" value="7">
                                 Operations Assistant Intern
                              </option>
                              <option id="sap_job_8" value="8">
                                 LLC Intern
                              </option>
                              <option id="sap_job_9" value="9">
                                 Programming Intern
                              </option>
                              <option id="sap_job_10" value="10">
                                 Computer Programmer
                              </option>
                              <option id="sap_job_11" value="11">
                                 Straight Line Hall Director
                              </option>
                              <option id="sap_job_12" value="12">
                                 Upperclass Hall Director
                              </option>
                              <option id="sap_job_13" value="13">
                                 Graphic Designer
                              </option>
                              <option id="sap_job_14" value="14">
                                 University Assistant
                              </option>
                              <option id="sap_job_15" value="15">
                                 Grad Intern
                              </option>
                              <option id="sap_job_16" value="16">
                                 Residence Life Assistant
                              </option>
                              <option id="sap_job_19" value="19">
                                 Resident Advisor
                              </option>
                              <option id="sap_job_20" value="20">
                                 Hall Council
                              </option>
                              <option id="sap_job_21" value="21">
                                 Residence Hall Association
                              </option>
                              <option id="sap_job_22" value="22">
                                 Programming Assistant
                              </option>
                              <option id="sap_job_23" value="23">
                                 Desk Attendant
                              </option>
                              <option id="sap_job_24" value="24">
                                 Marketing Specialist
                              </option>
                              <option id="sap_job_26" value="26">
                                 Operations Assistant
                              </option>
                           </select>
                        </td>
                        <td>
                           <input type="radio" name="active" id="active_yes" value="1">
                           <label for="active_yes">Yes</label>
                           <div class="popup">
                              <input type="radio" name="active" id="active_no" value="0" onclick="activeButton()"><label for="active_no">No</label>
                              <span class="popuptext" id="warning">Deactivate Employees Via the Deactivation Page</span>
                           </div>
                        </td>
                        <td>
                           <input type="radio" name="staff_admin" id="staff_admin_yes" value="2">
                           <label for="staff_admin_yes">Staff Admin</label>
                           <input type="radio" name="staff_admin" id="requester_yes" value="1">
                           <label for="requester_yes">Admin Requests</label>
                           <input type="radio" name="staff_admin" id="staff_admin_no" value="0">
                           <label for="staff_admin_no">Neither</label>
                        </td>

                     </tr>
                  </table>
               </div>
               <button type="button" class="advanced_buttons" onclick="showStaffPortal()">Advanced Staff Portal</button>
               <button type="button" class="advanced_buttons" onclick="showProgramPortal()">Advanced Program Portal</button>
               <button type="button" class="advanced_buttons" onclick="showFormAccess()">Advanced Form Access</button>

               <input type="text" name="staff_portal_was_changed" id="staff_portal_was_changed" value="0" hidden="">
               <input type="text" name="program_portal_was_changed" id="program_portal_was_changed" value="0" hidden="">
               <input type="text" name="forms_was_changed" id="forms_was_changed" value="0" hidden="">

               <div class="indepth_privileges_container" id="staff_portal_container">
                  <h4>Staff Portal Permissions</h4>
                  <table class="app_table">
                     <tr>
                        <th>Auth Level</th>
                        <th>Form Access</th>
                        <th>Programming Level</th>
                     </tr>
                     <tr>
                        <td>
                           <select name="auth_level" id="auth_level" required>
                              <option id="auth_level_0" value="0">No Level</option>
                              <option id="auth_level_1" value="1">Directors, IT Coordinator Level</option>
                              <option id="auth_level_6" value="6">Director: Upper-Class Communities Level</option>
                              <option id="auth_level_7" value="7">Director: Eduction Level</option>
                              <option id="auth_level_10" value="10">Operations Assistant Level</option>
                              <option id="auth_level_11" value="11">Test User</option>
                           </select>
                        </td>
                        <td>
                           <select name="form_access" id="form_access" required>
                              <option id="form_access_0" value="0">No Programming Portal</option>
                              <option id="form_access_1" value="1">Programming Portal Access</option>
                           </select>
                        </td>
                        <td>
                           <select name="programming_level" id="programming_level" required>
                              <option id="programming_0" value="0">Non-Central-Office Staff Level</option>
                              <option id="programming_1" value="1">Central Office Staff Level</option>
                              <option id="programming_5" value="5">Operations Level</option>
                              <option id="programming_6" value="6">Hall Director Level</option>
                              <option id="programming_7" value="7">Director: Education Level</option>
                           </select>
                        </td>
                     </tr>
                  </table>
                  <p><strong><u>Staff Portal Form Views</u></strong></p>
                  <input type="checkbox" name="permissions1" id="dev" value="dev">
                  <label for="dev">WIP Links</label>
                  <input type="checkbox" name="permissions2" id="banned_list" value="banned_list">
                  <label for="banned_list">Banned List</label>
                  <input type="checkbox" name="permissions3" id="housing_director" value="housing_director">
                  <label for="housing_director">The Housing Director</label>
                  <br>
                  <input type="checkbox" name="permissions4" id="admins" value="admins">
                  <label for="admins">Admins, Lots of access</label>
                  <input type="checkbox" name="permissions5" id="adminSection" value="adminSection">
                  <label for="adminSection">Admin Section, lesser</label>
                  <input type="checkbox" name="permissions6" id="graphics_portal" value="graphics_portal">
                  <label for="graphics_portal">Graphics Portal</label>
                  <br>
                  <input type="checkbox" name="permissions7" id="clockulator" value="clockulator">
                  <label for="clockulator">Clockulator</label>
                  <input type="checkbox" name="permissions8" id="judical_portal" value="judical_portal">
                  <label for="judical_portal">Judicial Portal, never used</label>
                  <input type="checkbox" name="permissions9" id="hall_directors" value="hall_directors">
                  <label for="hall_directors">Hall Director Views</label>
                  <input type="checkbox" name="permissions10" id="oa_array" value="oa_array">
                  <label for="oa_array">OA Portal</label>
               </div>

               <div class="indepth_privileges_container" id="program_portal_container">
                  <h4>Program Portal Permissions</h4>
                  <table class="app_table">
                     <tr>
                        <th>Main Role</th>
                        <th>Secondary Role</th>
                        <th>Reset Password</th>
                     </tr>
                     <tr>
                        <td>
                           <select id="program_portal_role" name="program_portal_role" required>
                              <option id="role_21" value=21>None</option>
                              <option id="role_20" value=20>Hall Council</option>
                              <option id="role_19" value=19>Resident Advisor</option>
                              <option id="role_16" value=16>Programming Assistant</option>
                              <option id="role_14" value=14>Directors Assistant</option>
                              <option id="role_13" value=13>Residence Hall Association</option>
                              <option id="role_12" value=12>University Assistant</option>
                              <option id="role_9" value=9>Programing Space Intern</option>
                              <option id="role_8" value=8>Operations Assistant</option>
                              <option id="role_7" value=7>Program Development Intern</option>
                              <option id="role_6" value=6>Upperclass Hall Director</option>
                              <option id="role_5" value=5>Straightline Hall Director</option>
                              <option id="role_4" value=4>Director: Upper-Class Communities</option>
                              <option id="role_3" value=3>Director of Operations</option>
                              <option id="role_2" value=2>Director of Education & Community</option>
                              <option id="role_1" value=1>Director of Housing</option>
                           </select>
                        </td>
                        <td>
                           <select id="program_portal_role2" name="program_portal_role2" required>
                              <option id="role2_21" value=21>None</option>
                              <option id="role2_20" value=20>Hall Council</option>
                              <option id="role2_19" value=19>Resident Advisor</option>
                              <option id="role2_16" value=16>Programming Assistant</option>
                              <option id="role2_14" value=14>Directors Assistant</option>
                              <option id="role2_13" value=13>Residence Hall Association</option>
                              <option id="role2_12" value=12>University Assistant</option>
                              <option id="role2_9" value=9>Programing Space Intern</option>
                              <option id="role2_8" value=8>Operations Assistant</option>
                              <option id="role2_7" value=7>Program Development Intern</option>
                              <option id="role2_6" value=6>Upperclass Hall Director</option>
                              <option id="role2_5" value=5>Straightline Hall Director</option>
                              <option id="role2_4" value=4>Director: Upper-Class Communities</option>
                              <option id="role2_2" value=2>IT Coordinator, Directors</option>
                              <option id="role2_1" value=1>Director of Housing</option>
                           </select>
                        </td>
                        <td>
                           <input type="radio" name="reset_pp_pass" id="reset_yes" value="1">
                           <label for="reset_yes">Yes</label>
                           <input type="radio" name="reset_pp_pass" id="reset_no" value="0" checked="true">
                           <label for="reset_no">No</label>
                        </td>
                     </tr>
                  </table>
                  <p><strong><u>Additional Halls:</u></strong></p>
                  <input type="checkbox" name="allhalls1" id="allhalls_1" value="1">
                  <label for="allhalls_1">Brownell</label>

                  <input type="checkbox" name="allhalls2" id="allhalls_2" value="2">
                  <label for="allhalls_2">Chase</label>

                  <input type="checkbox" name="allhalls3" id="allhalls_3" value="3">
                  <label for="allhalls_3">Farnham</label>

                  <input type="checkbox" name="allhalls4" id="allhalls_4" value="4">
                  <label for="allhalls_4">Hickerson</label>
                  <br>
                  <input type="checkbox" name="allhalls5" id="allhalls_5" value="5">
                  <label for="allhalls_5">Neff</label>

                  <input type="checkbox" name="allhalls6" id="allhalls_6" value="6">
                  <label for="allhalls_6">North</label>

                  <input type="checkbox" name="allhalls7" id="allhalls_7" value="7">
                  <label for="allhalls_7">Schwartz</label>

                  <input type="checkbox" name="allhalls8" id="allhalls_8" value="8">
                  <label for="allhalls_8">West</label>

                  <input type="checkbox" name="allhalls9" id="allhalls_9" value="9">
                  <label for="allhalls_9">Wilkinson</label>
                  <br> <br>
                  <p><strong><u>Program Portal Additional Roles</u></strong></p>
                  <input type="checkbox" name="allroles14" id="allroles_20" value="20">
                  <label for="allroles_20">Hall Council</label>
                  <input type="checkbox" name="allroles13" id="allroles_19" value="19">
                  <label for="allroles_19">Resident Advisor</label>
                  <input type="checkbox" name="allroles12" id="allroles_16" value="16">
                  <label for="allroles_16">Programming Assistant</label>
                  <br>
                  <input type="checkbox" name="allroles11" id="allroles_14" value="14">
                  <label for="allroles_14">Directors Assistant</label>
                  <input type="checkbox" name="allroles10" id="allroles_13" value="13">
                  <label for="allroles_13">Residence Hall Association</label>
                  <input type="checkbox" name="allroles9" id="allroles_12" value="12">
                  <label for="allroles_12">University Assistant</label>
                  <br>
                  <input type="checkbox" name="allroles8" id="allroles_9" value="9">
                  <label for="allroles_9">Programing Space Intern</label>
                  <input type="checkbox" name="allroles7" id="allroles_8" value="8">
                  <label for="allroles_8">Operations Assistant</label>
                  <input type="checkbox" name="allroles6" id="allroles_7" value="7">
                  <label for="allroles_7">Program Development Intern</label>
                  <input type="checkbox" name="allroles5" id="allroles_6" value="6">
                  <label for="allroles_6">Upperclass Hall Director</label>
                  <br>
                  <input type="checkbox" name="allroles4" id="allroles_5" value="5">
                  <label for="allroles_5">Straightline Hall Director</label>
                  <input type="checkbox" name="allroles3" id="allroles_4" value="4">
                  <label for="allroles_4">Director: Upper-Class Communities</label>
                  <input type="checkbox" name="allroles2" id="allroles_2" value="2">
                  <label for="allroles_2">IT Coordinator, Directors</label>
                  <input type="checkbox" name="allroles1" id="allroles_1" value="1">
                  <label for="allroles_1">Director of Housing</label>
               </div>
               <div class="indepth_privileges_container" id="form_container">
                  <h4>Form Permissions</h4>
                  <!-- This section dictates whether or not a user receives an email for the listed forms. The wording should be changed so that the user can understand what this  means 
					   maybe something like Email Permissions-->
                  <table class="app_table">
                     <tr>
                        <th>Maintenance</th>
                        <th>Comcast</th>
                        <th>Program Report</th>
                        <th>Farnham Report</th>
                        <th>Schwartz Report</th>
                        <th>Conn Report</th>
                        <th>Tech Requests</th>
                        <th>OA Requests</th>
                        <th>Van Requests</th>
                     </tr>
                     <tr>
                        <td>
                           <input type="radio" name="maintenance_requests" id="maintenance_requests_yes" value="1" onclick="formAccessChanged('resworkorder_changed')">
                           <label for="maintenance_requests_yes">Yes</label>
                           <input type="radio" name="maintenance_requests" id="maintenance_requests_no" value="0" onclick="formAccessChanged('resworkorder_changed')">
                           <label for="maintenance_requests_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="comcast_requests" id="comcast_requests_yes" value="1" onclick="formAccessChanged('resworkorder_changed')">
                           <label for="comcast_requests_yes">Yes</label>
                           <input type="radio" name="comcast_requests" id="comcast_requests_no" value="0" onclick="formAccessChanged('resworkorder_changed')">
                           <label for="comcast_requests_no">No</label>
                           <input type="text" name="inResWorkOrder" value="<?php if ($resworkorder == false) {
                                                                              echo 0;
                                                                           } else {
                                                                              echo 1;
                                                                           } ?>" hidden>
                        </td>
                        <td>
                           <input type="radio" name="program_report" id="program_report_yes" value="1" onclick="formAccessChange('reslife_pdsadm_changed')">
                           <label for="program_report_yes">Yes</label>
                           <input type="radio" name="program_report" id="program_report_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="program_report_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="farnham_report" id="farnham_report_yes" value="1" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="farnham_report_yes">Yes</label>
                           <input type="radio" name="farnham_report" id="farnham_report_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="farnham_report_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="schwartz_report" id="schwartz_report_yes" value="1" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="schwartz_report_yes">Yes</label>
                           <input type="radio" name="schwartz_report" id="schwartz_report_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="schwartz_report_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="conn_report" id="conn_report_yes" value="1" onclick="formAccessChanged('reslife_pdsadm_changed')"><label for="conn_report_yes">Yes</label>
                           <input type="radio" name="conn_report" id="conn_report_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')"><label for="conn_report_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="tech_requests" id="tech_requests_yes" value="1" onclick="formAccessChanged('reslife_pdsadm_changed')">
                           <label for="tech_requests_yes">Yes</label>
                           <input type="radio" name="tech_requests" id="tech_requests_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')"><label for="tech_requests_no">No</label>
                        </td>
                        <td>
                           <input type="radio" name="oa_requests" id="oa_requests_yes" value="1" onclick="formAccessChanged('reslife_pdsadm_changed')"><label for="oa_requests_yes">Yes</label>
                           <input type="radio" name="oa_requests" id="oa_requests_no" value="0" onclick="formAccessChanged('reslife_pdsadm_changed')"><label for="oa_requests_no">No</label>
                           <input type="text" name="inPdsAdm" value="<?php if ($reslife_pdsadm == false) {
                                                                        echo 0;
                                                                     } else {
                                                                        echo 1;
                                                                     } ?>" hidden>

                        </td>

                        <td>
                           <input type="radio" name="van_requests" id="van_requests_yes" value="1" onclick="formAccessChanged('tutorctr_changed')">
                           <label for="van_requests_yes">Yes</label>
                           <input type="radio" name="van_requests" id="van_requests_no" value="0" onclick="formAccessChanged('tutorctr_changed')">
                           <label for="van_requests_no">No</label>
                           <input type="text" name="inTutorCtr" value="<?php if ($tutorctr == false) {
                                                                           echo 0;
                                                                        } else {
                                                                           echo 1;
                                                                        } ?>" hidden>
                        </td>
                     </tr>
                  </table>
                  <input type="text" name="resworkorder_changed" id="resworkorder_changed" value="0" hidden>
                  <input type="text" name="reslife_pdsadm_changed" id="reslife_pdsadm_changed" value="0" hidden>
                  <input type="text" name="tutorctr_changed" id="tutorctr_changed" value="0" hidden>
               </div>
               <br><br>
               <input type="submit" name="Submit">
            </form>
      </div>
   </div>
</div>
<script type="text/javascript">
   function activeButton() {
      var staff_data = <?php echo json_encode($staff_data); ?>;

      if (staff_data["active"] == 1) {
         var popup = document.getElementById("warning");
         popup.classList.toggle("show");
         document.getElementById("active_yes").checked = true;
      }
   }

   function staffAdminPortalDataFields() {
      var staff_data = <?php echo json_encode($staff_data); ?>;

      //*Sets the Simple Update Job Based on DB
      index = "sap_job_" + staff_data.job_id
      document.getElementById(index).selected = true

      //*Sets The Simple Update Hall Based on DB
      index = staff_data.hall_id
      // console.log(index)
      document.getElementById("sap_hall").selectedIndex = index - 1

      //*Sets Whether a User is Active or not in the Res Life System
      if (staff_data['active'] == 1) {
         document.getElementById("active_yes").checked = true;
      } else {
         document.getElementById("active_no").checked = true;
      }
      //*Sets Whether a users is an admin, requester or neither
      if (staff_data['admin'] == 1) {
         document.getElementById("requester_yes").checked = true;
      } else if (staff_data['admin'] == 2) {
         document.getElementById("staff_admin_yes").checked = true;
      } else {
         document.getElementById("staff_admin_no").checked = true;
      }
   }

   function staffPortalDataFields() {
      var auth_data = <?php echo json_encode($auth_data); ?>

      //*set Staff Portal Auth Level Drop Down
      index = "auth_level_" + auth_data.auth_level
      document.getElementById(index).selected = true

      //*set Staff Portal Form Access Drop Down
      document.getElementById("form_access").selectedIndex = auth_data.form_access

      //*set Staff Portal Programming Level Drop Down
      index = "programming_" + auth_data.programming_level
      document.getElementById(index).selected = true
   }

   function programPortalDataFields() {
      var users_data = <?php echo json_encode($users_data); ?>;

      //*set Program Portal Role Drop Down
      var index = "role_" + users_data.role;
      document.getElementById(index).selected = true;

      //*set Program Portal Role 2 Drop Down
      index = "role2_" + users_data.role2;
      if (users_data.role2 != null) {
         document.getElementById(index).selected = true;
      }

      var allhalls = users_data.allhalls;
      if (allhalls != null && allhalls != "") {
         allhalls = allhalls.split(",");
         for (var i = 0; i <= allhalls.length - 1; i++) {
            index = "allhalls_" + allhalls[i];
            // document.getElementById("allroles_" + users_data[i]).checked = true;
            document.getElementById(index).checked = true;
         }
      }

      users_data = users_data.allroles;
      // var users_data = users_data['allroles'];
      if (users_data != null && users_data != "") {
         users_data = users_data.split(",");
         for (var i = 0; i <= users_data.length - 1; i++) {
            index = "allroles_" + users_data[i];
            // document.getElementById("allroles_" + users_data[i]).checked = true;
            document.getElementById(index).checked = true;
         }
      }
   }

   function formFields() {
      var staff_data = <?php echo json_encode($staff_data); ?>;

      if (staff_data) {
         if (staff_data['van_requests'] == 1) {
            document.getElementById("van_requests_yes").checked = true;
         } else {
            document.getElementById("van_requests_no").checked = true;
         }
         if (staff_data['comcast_requests'] == 1) {
            document.getElementById("comcast_requests_yes").checked = true;
         } else {
            document.getElementById("comcast_requests_no").checked = true;
         }
         if (staff_data['maintenance_requests'] == 1) {
            document.getElementById("maintenance_requests_yes").checked = true;
         } else {
            document.getElementById("maintenance_requests_no").checked = true;
         }
         if (staff_data['program_report'] == 1) {
            document.getElementById("program_report_yes").checked = true;
         } else {
            document.getElementById("program_report_no").checked = true;
         }
         if (staff_data['farnham_report'] == 1) {
            document.getElementById("farnham_report_yes").checked = true;
         } else {
            document.getElementById("farnham_report_no").checked = true;
         }
         if (staff_data['schwartz_report'] == 1) {
            document.getElementById("schwartz_report_yes").checked = true;
         } else {
            document.getElementById("schwartz_report_no").checked = true;
         }
         if (staff_data['conn_report'] == 1) {
            document.getElementById("conn_report_yes").checked = true;
         } else {
            document.getElementById("conn_report_no").checked = true;
         }
         if (staff_data['tech_requests'] == 1) {
            document.getElementById("tech_requests_yes").checked = true;
         } else {
            document.getElementById("tech_requests_no").checked = true;
         }
         if (staff_data['oa_requests'] == 1) {
            document.getElementById("oa_requests_yes").checked = true;
         } else {
            document.getElementById("oa_requests_no").checked = true;
         }
         if (staff_data['van_requests'] == 1) {
            document.getElementById("van_requests_yes").checked = true;
         } else {
            document.getElementById("van_requests_no").checked = true;
         }
      } else {
         document.getElementById("comcast_requests_no").checked = true;
         document.getElementById("maintenance_requests_no").checked = true;
         document.getElementById("van_requests_no").checked = true;
         document.getElementById("program_report_no").checked = true;
         document.getElementById("farnham_report_no").checked = true;
         document.getElementById("schwartz_report_no").checked = true;
         document.getElementById("conn_report_no").checked = true;
         document.getElementById("tech_requests_no").checked = true;
         document.getElementById("oa_requests_no").checked = true;
         document.getElementById("van_requests_no").checked = true;

      }
   }

   function createReadableDataFields() {
      //*Set Staff Portal Fields Based on Current User Data
      staffAdminPortalDataFields();
      staffPortalDataFields();
      programPortalDataFields();
      formFields();
   }

   function showStaffPortal() {
      var e = document.getElementById('staff_portal_container');
      var f = document.getElementById('staff_portal_was_changed');
      if (e.style.display == "block") {
         e.style.display = "none";
         f.value = 0
      } else {
         e.style.display = "block"
         f.value = 1
      }
   }

   function showProgramPortal() {
      var e = document.getElementById('program_portal_container');
      var f = document.getElementById('program_portal_was_changed');
      if (e.style.display == "block") {
         e.style.display = "none";
         f.value = 0;
      } else {
         e.style.display = "block";
         f.value = 1;
      }
   }

   function showFormAccess() {
      var e = document.getElementById('form_container');
      var f = document.getElementById('forms_was_changed');

      if (e.style.display == "block") {
         e.style.display = "none";
         f.value = 0;
      } else {
         e.style.display = "block";
         f.value = 1;
      }
   }

   function formAccessChanged(form) {
      var e = document.getElementById(form);
      e.value = 1;
   }
</script>