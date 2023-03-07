package com.example.projectmanagement.response.report

data class ReportResponse(
    val `data`: Data,
    val message: String,
    val success: Boolean
)