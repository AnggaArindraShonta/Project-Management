package com.example.projectmanagement.api

import com.example.projectmanagement.response.member.MemberResponse
import com.example.projectmanagement.response.member.User
import com.example.projectmanagement.response.pic.PicResponse
import com.example.projectmanagement.response.report.ReportResponse
import com.example.projectmanagement.response.report.ReportResponsePost
import com.example.projectmanagement.response.signin.SignInResponse
import com.example.projectmanagement.response.signup.SignUpResponse
import com.example.projectmanagement.response.user.UserResponse
import com.example.toko.response.produk.ProjectResponse
import com.example.toko.response.produk.ProjectResponsePost
import okhttp3.MultipartBody
import okhttp3.RequestBody
import retrofit2.Call
import retrofit2.http.*

interface ApiEndpoint {
    @FormUrlEncoded
    @POST("login")
    fun SignIn(
        @Field("user_name") user_name : String,
        @Field("user_email") user_email : String,
        @Field("password") password : String
    ) : Call<SignInResponse>

    @FormUrlEncoded
    @POST("user")
    fun SignUp(
        @Field("user_name") user_name : String,
        @Field("user_email") user_email : String,
        @Field("password") password : String,
        @Field("role_id") role_id : String
    ) : Call<SignUpResponse>


    @GET("user")
    fun getMember(
        @Header("Authorization") token: String
    ): Call <MemberResponse>

    @GET("pic")
    fun getPic(
        @Header("Authorization") token: String
    ): Call <PicResponse>

    @GET("project_by_member")
    fun getProjectMember(
        @Query("user_id") user_id: Int,
        @Header("Authorization") token: String
    ): Call <ProjectResponse>


    @GET("project")
    fun  getProject(
        @Header("Authorization") token: String
    ) : Call <ProjectResponse>

    @Multipart
    @POST("project")
    fun postProject(
//        @Header("Authorization") token: String,
        @Part("project_name") project_name: RequestBody,
        @Part("start_date") start_date: RequestBody,
        @Part("end_date") end_date: RequestBody,
        @Part("project_description") project_description: RequestBody,
        @Part project_picture: MultipartBody.Part,

        @Part("pic_id") pic_id: RequestBody,
        @Part("member") member: RequestBody
    ) : Call<ProjectResponsePost>

    @FormUrlEncoded
    @HTTP(method = "DELETE" , path = "project", hasBody = true)
    fun  deleteProject(
        @Header("Authorization") token: String,
        @Field("project_id") project_id : Int
    ) : Call <ProjectResponse>

    @FormUrlEncoded
    @HTTP(method = "PUT" , path = "project", hasBody = true)
    fun  putProject(
        @Header("Authorization") token: String,
        @Field("project_name") project_name : String,
        @Field("start_date") start_date : String,
        @Field("end_date") end_date : String,
        @Field("project_description") project_description : String,
        @Field("project_picture") project_picture : String,
        @Field("pma_id") pma_id : Int
    ) : Call <ProjectResponsePost>

    @GET("user")
    fun getUser(

    ): Call <UserResponse>

    @GET("report")
    fun getReport(
        @Header("Authorization") token: String
    ): Call <ReportResponse>


    @GET("report_by_member")
    fun getReportByUser(
        @Query("user_id") user_id: Int,
        @Header("Authorization") token: String
    ): Call <ReportResponse>

    @Multipart
    @POST("report")
    fun postReport(
//        @Header("Authorization") token: String,
        @Part report_progress: MultipartBody.Part,
        @Part("report_nota") report_nota: RequestBody,
        @Part("report_date") report_date: RequestBody,
        @Part("report_time") report_time: RequestBody,
        @Part("project_id") project_id: RequestBody,
        @Part("pma_id") pma_id: RequestBody,
        @Part("member") member: RequestBody
    ) : Call<ReportResponsePost>


}