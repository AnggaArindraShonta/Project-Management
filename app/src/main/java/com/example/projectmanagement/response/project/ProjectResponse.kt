package com.example.toko.response.produk

import com.example.projectmanagement.response.project.Data


data class ProjectResponse(
    val success : Boolean,
    val message : String,
    val data: Data
)
