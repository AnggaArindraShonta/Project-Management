package com.example.toko.response.produk

import com.example.projectmanagement.response.project.Project

data class ProjectResponsePost (
    val data: DataProject,
    val message : String,
    val success : Boolean
)

data class DataProject(
    val project : Project
)