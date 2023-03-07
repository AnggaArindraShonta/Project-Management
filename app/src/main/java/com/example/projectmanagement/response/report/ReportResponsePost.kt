package com.example.projectmanagement.response.report


data class ReportResponsePost(
val data: DataReport,
val message : String,
val success : Boolean
)

data class DataReport(
    val report: Report
)