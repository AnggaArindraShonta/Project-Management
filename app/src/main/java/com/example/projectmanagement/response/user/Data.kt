package com.example.projectmanagement.response.user


import com.google.gson.annotations.SerializedName

data class Data(
    @SerializedName("user")
    val user: List<User>
)