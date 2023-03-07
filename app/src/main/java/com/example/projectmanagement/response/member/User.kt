package com.example.projectmanagement.response.member

data class User(
    val password: String,
    val role_id: String,
    val user_email: String,
    val user_id: String,
    val user_name: String
)