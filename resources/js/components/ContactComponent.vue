<template>
<div class="id pt-3">



 <div class="container py-3">
  <div class="row container">
   <div class="mr-2 ">
    <h1 class="display-4 text-center" style="font-family:serif">Get In Touch</h1>
    <p class="lead text-muted mb-0" style="font-family:serif">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here,</p><br>
   </div>
  </div>
  <div class="row">
   <div class="col-lg-6 mx-auto">
    <li v-for="(audio, index) in audioFiles" :key="index">
     <audio controls>
      <source :src="audio.url" type="audio/mpeg">
      Your browser does not support the audio element.
     </audio>
    </li>

    <div class="card mt-5" style="box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px; border-radius:20px;padding:15px">
     <div class="card-body">

      <form @reset="reset" @submit.prevent="sendMessage()" id="contactForm" name="contactForm" class="contactForm ">
       <div class="row">
        <div class="col-md-6">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Firstname:</p>
          <input v-model="form.firstname" type="text" name="firstname" placeholder="Enter firstname" class="form-control" />
         </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Lastname:</p>
          <input v-model="form.lastname" type="text" name="lastname" placeholder="Enter lastname" class="form-control" />
         </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Email Address:</p>
          <input v-model="form.email" name="email" id="email" placeholder="Enter email" class="form-control" />
         </div>
        </div>
        <div class="col-md-6">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Phone:</p>
          <input v-model="form.mobile" type="text" name="mobile" placeholder="Enter mobile number" class="form-control" />
         </div>
        </div>

        <div class="col-md-12">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Subject:</p>
          <input v-model="form.subject" type="text" name="subject" placeholder="Enter subject" class="form-control" />
         </div>
        </div>
        <div class="col-md-12">
         <div class="form-group">
          <p class="lead mb-0" style="color:black">Message:</p>
          <textarea v-model="form.message" rows="4" type="text" name="message" placeholder="Enter message" class="form-control" />
          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="submit" value="Send Message" class="btn btn-success text-white btn-lg">
                          </div>
                        </div>
                    </div>
                  </form>
                </div>
            </div>

          
        </div>
        <div class="col-lg-6 mt-5 d-none d-lg-block"><img src="/images/message.png" alt="" class="img-fluid"></div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
 
 data() {
  return {
  
   feedback: {},
   form: new Form({
    firstname: "",
    lastname: "",
    email: "",
    subject: "",
    mobile: "",
    message: ""
   }),

  }
 },

 methods: {
  

  sendMessage() {
   Swal.fire({
    title: "Are you sure?",
    text: "You want to send the message !",
    showCancelButton: true,
    confirmButtonColor: "green",
    cancelButtonColor: "#d33",
    confirmButtonText: "Send message!",
   }).then((result) => {
    if (result.isConfirmed) {
     axios
      .post("/api/send-message", this.form)
      .then((res) => {
       if (!res.data.success) {
        Swal.fire({
         position: "top-end",
         icon: "success",
         title: "Message sent successfully ",
         showConfirmButton: false,
         timer: 1500,
        });
        this.form.reset();
        $("#addNew").hide();

       } else if (res.data.success) {
        Swal.fire(
         "Error!",
         "Unable to send message.",
         "error"
        );
        this.form.reset();
        self.close();
       }
      })
      .catch(function (err) {});
    }
   });
  },

 }
 }
</script>

<style scoped>

</style>
