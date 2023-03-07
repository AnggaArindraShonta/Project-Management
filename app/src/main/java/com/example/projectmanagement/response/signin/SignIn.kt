package com.example.projectmanagement.response.signin

data class SignIn(
    val user_id: String,
    val user_name: String,
    val user_email:String,
    val password :String,
    val role_id:String,
)
