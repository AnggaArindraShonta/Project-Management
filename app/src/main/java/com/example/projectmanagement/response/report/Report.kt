package com.example.projectmanagement.response.report

data class Report(
    val member: String,
    val project_id: String,
    val project_name: String,
    val report_date: String,
    val report_id: String,
    val report_nota: String,
    val ket_nota: String,
    val report_progress: String,
    val ket_progress:String,
    val report_time: String,
    val user_name: String
)