package com.example.projectmanagement.response.signup

data class SignUp(
    val user_id: String,
    val user_name: String,
    val user_email:String,
    val password :String,
    val role_id:String,
)
