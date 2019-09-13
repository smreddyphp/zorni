
<!DOCTYPE html>
<?php 
echo date('Y-m-d h:i:s a')." "; 
echo date_default_timezone_get();
?>

<html lang="en">
<head>
  <title>Mobile Services</title>
  <meta charset="utf-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Mobile Services</h2>  
   <table class="table table-striped" width="100%">
    <thead> 
    <tr>
    	<th>Date</td>        
        <th>Service Name</th>
        <th>Method</th>
        <th>Parameters</th>
        <th>API Link</th>      
    </tr>
    <thead> 
    <tbody>
      <tr>
        <td>12/04/2018</td>
        <td>SignUp For user,doctor,clinic,freedental</td>
        <td>POST</td>
        <td>username,password,mobile,age,gender,email,device_type,device_token,lang {free dental for adding extra params(package_id,package_price)}</td>
        <td>http://www.volivesolutions.com/zorni/api/services/registration/</td>
      </tr>
      <tr>
        <td>12/04/2018</td>
        <td>User Login</td>
        <td>POST</td>
        <td>email,password,device_type,device_token,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/check_user_login</td>
      </tr>
      <tr class="success">
        <td>13/04/2018</td>
        <td>get Users</td>
        <td>GET</td>
        <td>auth_level{1 or 2 or 3 or 4},lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user/{parameter}</td>
      </tr>
      <tr>
        <td>13/04/2018</td>
        <td>Users Forgot Password</td>
        <td>POST</td>
        <td>email</td>
        <td>http://www.volivesolutions.com/zorni/api/services/forgot_password</td>
      </tr>
      <tr class="success">
        <td>16/04/2018</td>
        <td>Get single User Details</td>
        <td>GET</td>
        <td>auth_level,user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user/{auth_level}/{user_id}</td>
      </tr>
      <tr class="success">
        <td>17/04/2018</td>
        <td>provided services & accepted insurances</td>
        <td>GET</td>
        <td></td>
        <td>http://www.volivesolutions.com/zorni/api/services/provided_services_accepted_insurances</td>
      </tr>
      <tr class="success">
        <td>17/04/2018</td>
        <td>offers</td>
        <td>GET</td>
        <td>lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/offers</td>
      </tr>
      <tr>
        <td>18/04/2018</td>
        <td>follow</td>
        <td>POST</td>
        <td>user_id,following_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_follow</td>
      </tr>
      <tr>
        <td>18/04/2018</td>
        <td>un-follow</td>
        <td>POST</td>
        <td>user_id,following_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_unfollow</td>
      </tr>
      <tr class="success">
        <td>18/04/2018</td>
        <td>user Following List</td>
        <td>GET</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_user_following</td>
      </tr> 
      <tr>
        <td>18/04/2018</td>
        <td>user Give Ratings</td>
        <td>POST</td>
        <td>user_id,rater_id,id,auth_level,ratings,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_give_ratings</td>
      </tr>
      <tr class="success">
        <td>20/04/2018</td>
        <td>doctors category wise list</td>
        <td>GET</td>
        <td>lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_category_wise_doctors</td>
      </tr>
      <tr>
        <td>21/04/2018</td>
        <td>Clinic appointment Booking</td>
        <td>POST</td>
        <td>user_id,booking_id,name,customer_age,customer_gender,date,time,mobile,service,doctor_name,auth_level,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/book_appointment</td>
      </tr>      
      <tr>
        <td>21/04/2018</td>
        <td>User Change Password</td>
        <td>POST</td>
        <td>user_id,currentpassword,newpassword,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/change_password</td>
      </tr>
      <tr class="success">
        <td>23/04/2018</td>
        <td>Clinic Doctors Based On Service</td>
        <td>GET</td>
        <td>clinic_id,service_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_clinic_doctors_based_on_service/{clinic_id}/{service_id}</td>
      </tr>
      <tr class="success">
        <td>25/04/2018</td>
        <td>Get tweets</td>
        <td>GET</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_tweets/{user_id}</td>
      </tr> 
      <tr>
        <td>25/04/2018</td>
        <td>User Update Profile</td>
        <td>POST</td>
        <td>user_id,username,email,mobile,image,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_update_profile</td>
      </tr> 
      <tr>
        <td>25/04/2018</td>
        <td>User Reservations</td>
        <td>POST</td>
        <td>user_id,auth_level</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_reservations</td>
      </tr>
      <tr class="success">
        <td>30/04/2018</td>
        <td>Free Dental Packages</td>
        <td>GET</td>
        <td>lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_packages</td>
      </tr> 
      <tr class="success">
        <td>02/05/2018</td>
        <td>All Users Data</td>
        <td>GET</td>
        <td>lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_all_users</td>
      </tr>
      <tr>
        <td>07/05/2018</td>
        <td>Get User Notifications</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_user_notifications</td>
      </tr>      
        <tr>
        <td>10/05/2018</td>
        <td>Clinic Filter Search </td>
        <td>POST</td>
        <td>clinic_name,service,insurance,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/clinic_filter_search</td>
      </tr> 
       <tr class="success">
        <td>15/05/2018</td>
        <td>Chat List</td>
        <td>GET</td>
        <td>sender_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_chat_list</td>
      </tr>
      <tr class="success">
        <td>16/05/2018</td>
        <td>chat view</td>
        <td>POST</td>
        <td>sender_id,reciver_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/chat_view</td>
      </tr> 
      <tr>
        <td>17/05/2018</td>
        <td>Medical Advice Request For Doctor</td>
        <td>POST</td>
        <td>user_id,doctor_id,description,fees,medical_slip,file_type</td>
        <td>http://www.volivesolutions.com/zorni/api/services/request_doctor_medical_advice</td>
      </tr>
       <tr>
        <td>17/05/2018</td>
        <td>Chat</td>
        <td>POST</td>
        <td>sender_id,reciver_id,message,message_type,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/chat</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>get followers</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_followers</td>
      </tr> 
      <tr>
        <td>24/05/2018</td>
        <td>get raters</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_ratings</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>Medical Advice Requests</td>
        <td>POST</td>
        <td>doctor_id,status,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/medical_advice_requests</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>All Tweets</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/all_tweets</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>Doctor Provided Offers</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_offers</td>
      </tr> 
     <tr>
        <td>24/05/2018</td>
        <td>Offer Add</td>
        <td>POST</td>
        <td>user_id,promo_code,percentage,description,description_ar,expire_date,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/offers_add</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>Update Offer</td>
        <td>POST</td>
        <td>id,promo_code,percentage,description,description_ar,expire_date,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/update_offer</td>
      </tr> 
      <tr>
        <td>24/05/2018</td>
        <td>Delete Offer</td>
        <td>POST</td>
        <td>id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/delete_offer</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>Medical Advice Requests Confirm or cancel{confirm = 1 and cancel = 2}</td>
        <td>POST</td>
        <td>id,status,user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/change_medical_advice_status</td>
      </tr>
      <tr>
        <td>24/05/2018</td>
        <td>Medical Advice Requests Delete</td>
        <td>POST</td>
        <td>id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/delete_medical_advice_request</td>
      </tr>
      <tr>
        <td>31/05/2018</td>
        <td>Doctor Update Profile</td>
        <td>POST</td>
        <td>username,about_dr,mobile,dr_fees,email,location,user_id,lat,lon,image,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/doctor_update_profile</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>doctor details For Home screen</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/doctor_details</td>
      </tr>
       <tr>
        <td>1/06/2018</td>
        <td>doctor chat list</td>
        <td>GET</td>
        <td>doctor_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/doctor_chat_list</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Free dental chat list</td>
        <td>GET</td>
        <td>free_dental_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/free_dental_chat_list</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Free Dental appointment Booking</td>
        <td>POST</td>
        <td>user_id,booking_id,name,customer_age,customer_gender,date,time,mobile,service,auth_level,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/free_dental_book_appointment</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Free Dental Appointments</td>
        <td>POST</td>
        <td>free_dental_id,status,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/free_dental_appointments</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Free Dental Appointments Confirm or cancel{confirm = 1 and cancel = 2}</td>
        <td>POST</td>
        <td>id,status,user_id,booking_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/free_dental_appointment_change_status</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>add_tweet</td>
        <td>POST</td>
        <td>user_id,tweet_title,tweet_title_ar,tweet,tweet_ar,tweet_image,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/add_tweet</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Update tweet</td>
        <td>POST</td>
        <td>user_id,tweet_title,tweet_title_ar,tweet,tweet_ar,id,image,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/add_tweet</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Delete tweet</td>
        <td>POST</td>
        <td>id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/delete_tweet</td>
      </tr>
      <tr>
        <td>1/06/2018</td>
        <td>Update Sign Out Time and Device Token</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/update_sign_out_time_device_token</td>
      </tr>
      <tr>
        <td>6/06/2018</td>
        <td> Free Dental Delete Appointment</td>
        <td>POST</td>
        <td>id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/free_dental_delete_appointment</td>
      </tr>      
       <tr>
        <td>06/06/2018</td>
        <td>Get Doctor Notifications</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_doctor_notifications</td>
      </tr> 
       <tr>
        <td>16/07/2018</td>
        <td>Free dentals based on city</td>
        <td>POST</td>
        <td>city,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/get_free_dentals_city_base</td>
      </tr>
       <tr>
        <td>20/07/2018</td>
        <td>User cancel Appointments</td>
        <td>POST</td>
        <td>id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_appointment_cancel</td>
      </tr>
      <tr>
        <td>27/07/2018</td>
        <td>User re-confirm Appointments</td>
        <td>POST</td>
        <td>id,status,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_reconfirm_appointment</td>
      </tr>
       <tr>
        <td>31/07/2018</td>
        <td>User un read notifications count</td>
        <td>POST</td>
        <td>user_id</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_un_read_notification_count</td>
      </tr>
      <tr>
        <td>06/08/2018</td>
        <td>count appointments</td>
        <td>POST</td>
        <td>user_id,auth_level</td>
        <td>http://www.volivesolutions.com/zorni/api/services/total_count_appointments</td>
      </tr>
      <tr>
        <td>25/09/2018</td>
        <td>delete Free dental Conversion</td>
        <td>POST</td>
        <td>sender_id,reciver_id</td>
        <td>http://www.volivesolutions.com/zorni/api/services/delete_free_dental_conversion</td>
      </tr>
      <tr>
        <td>25/09/2018</td>
        <td>User Update Language</td>
        <td>POST</td>
        <td>user_id,lang</td>
        <td>http://www.volivesolutions.com/zorni/api/services/user_update_language</td>
      </tr>
      </tbody> 
</table>
</div>
</body>
</html>