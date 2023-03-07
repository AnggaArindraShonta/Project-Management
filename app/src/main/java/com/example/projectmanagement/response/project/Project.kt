package com.example.projectmanagement.response.project

import android.os.Parcelable
import kotlinx.parcelize.Parcelize

@Parcelize
data class Project(
    val project_id : String,
    val project_name : String,
    val start_date : String,
    val end_date : String,
    val project_description : String,
    val project_picture :String,
    val pic_name : String,
    val member : String
):Parcelable
