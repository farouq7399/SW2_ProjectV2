Vue.component("newPost", {
  data: function () {
    return {
      title: "",
      date: "",
      content: "",
      likes: 0,
      newPost: 0,
      limitmaxCount: 200,
      totalRemainCount: 200,
      postContent: "",
      generateErr: false,
      liked: false,
    };
  },
  props: ["author"],
  template: `
              <div class="post-box">
                <div v-if="newPost == 0">
                  <form action="profile.php?username=<?php echo $username; ?>" method="post">
                    <h2 class="title">What is in your mind?!</h2><br>
                    <input type="text" v-model="title" placeholder="Title of the post .."><br>
                    <textareaname="postbody"  for="content" placeholder="Content of the post .."
                    maxlength="200" v-on:keyup="liveCountDown" v-model="postContent"></textarea><br>
                    <p class="remaining" :style="{color: generateErr ? '#c22210' : '#0a4068'}">Remaining characters: <span>{{totalRemainCount}}</span></p><br>
                    <input type="submit" name="post" value="SUBMIT" :disabled="!title || !postContent" @click.prevent="createPost">
                  </form>
                </div>
                <div class="post-body" v-else>
                  <h2 class="title">{{ title }}</h2>
                  <button class="delete-button" @click="deletePost">Delete</button>
                  <div class="post-date">{{ date }}</div>
                  <p class="content">{{content}}</p>
                  <div class="likes"><i id="like" class="fa-heart" :class="[liked ? 'fas' : 'far']" @click="likesCounter"></i><span>{{likes}} likes</span></div>
                  <button class="edit-button" @click="editPost">Edit</button>
                </div>
              </div>
            `,
  methods: {
    liveCountDown: function () {
      this.totalRemainCount = this.limitmaxCount - this.postContent.length;
      if (this.totalRemainCount == 0) {
        this.generateErr = true;
      } else {
        this.generateErr = false;
      }
    },
    createPost: function () {
      this.newPost += 1;
      this.content = this.postContent;
      this.getNow();
    },
    likesCounter: function () {
      this.liked = !this.liked;
      let likesNumber = document.getElementById("like");
      if (likesNumber.classList.contains("far") == true) {
        this.likes += 1;
      } else {
        this.likes -= 1;
      }
    },
    deletePost: function () {
      this.$el.parentNode.removeChild(this.$el);
      this.$destroy();
    },
    editPost: function () {
      this.newPost = 0;
    },
    getNow: function () {
      const today = new Date();
      const date =
        today.getFullYear() +
        "/" +
        (today.getMonth() + 1) +
        "/" +
        today.getDate();
      const time =
        today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      const dateTime = date + " " + time;
      this.date = dateTime;
    },
    createContent() {
      this.content = this.postContent;
    },
  },
});

let vm = new Vue({
  el: "#emad-app",
  data: {
    fieldType: "password",
    formErrors: [],
    userName: null,
    password: null,
    email: null,
    resetEmail: null,
    maxChars: 15,
    minChars: 8,
    selected: false,
    dbEmail: "mohamed@yahoo.com",
    range: 1,
    title: "",
    content: "",
    author:"",
  },
  methods: {
    switchField: function () {
      this.fieldType = this.fieldType === "password" ? "text" : "password";
      // first this.fieldType refers to filedType property
    },
    validateForm: function (e) {
      this.formErrors = []; // Empty errors to start fresh
      // [1] Check username characters count
      if (this.userName && this.userName.length > this.maxChars) {
        this.formErrors.push(
          "Username can't be more than ${this.maxChars} chracters"
        );
      }
      // [2] Check password characters count
      if (this.password && this.password.length < this.minChars) {
        this.formErrors.push(
          "Password can't be less than ${this.minChars} chracters"
        );
      }
      // [3] Check email validation
      if (this.email || this.resetEmail) {
        if (!this.validEmail(this.email || this.resetEmail)) {
          this.formErrors.push("Valid email required");
        }
      }
      // [4] Check database email
      if (this.resetEmail) {
        if (this.resetEmail !== this.dbEmail) {
          this.formErrors.push("This email is not in our database");
        }
      }
      // If no errors return true
      if (!this.formErrors.length) {
        return true;
      }
      e.preventDefault();
    },
    validEmail: function (email) {
      var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    addForm: function () {
      this.range += 1;
    },
  },
});
