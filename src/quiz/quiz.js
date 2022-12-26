/**
 * Vue Application for Shortcode
 */
 import Vue from "vue";
import App from "./App.vue";
   
 var app = new Vue( {
     el: '#vue-quiz-app',
     components: {
         'quiz': App
     }
 } ); 