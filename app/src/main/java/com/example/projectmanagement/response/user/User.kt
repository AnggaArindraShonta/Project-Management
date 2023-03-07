package com.example.projectmanagement.response.user


import com.google.gson.annotations.SerializedName

data class User(
    @SerializedName("password")
    val password: String,
    @SerializedName("role_id")
    val roleId: String,
    @SerializedName("status")
    val status: String,
    @SerializedName("user_email")
    val userEmail: String,
    @SerializedName("user_id")
    val userId: String,
    @SerializedName("user_name")
    val userName: String
)