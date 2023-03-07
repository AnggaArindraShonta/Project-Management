package com.example.projectmanagement.fragment

import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.projectmanagement.R
import com.example.projectmanagement.SignInActivity
import com.example.projectmanagement.adapter.ProjectAdapter
import com.example.projectmanagement.adapter.ReportAdapter
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.report.ReportResponse
import com.example.toko.response.produk.ProjectResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class DailyReportFragment : Fragment() {

    private val api by lazy { BaseRetrofit().endpoint }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        val view = inflater.inflate(R.layout.fragment_daily_report, container, false)

        val role= SignInActivity.sessionManager.getString("ROLE")
        Log.d("Cek Role", role.toString())

        if(role=="ADMIN"){
            getAllReport(view)
        } else {

            getReportByUser(view)

        }
        return view;
    }

    fun getAllReport(view: View) {
        val token = SignInActivity.sessionManager.getString("TOKEN")

        api.getReport(token.toString()).enqueue(object : Callback<ReportResponse> {
            override fun onResponse(
                call: Call<ReportResponse>,
                response: Response<ReportResponse>
            ) {
                Log.d("ProdukData", response.body().toString())

                val rv = view.findViewById(R.id.rv_report) as RecyclerView

                rv.setHasFixedSize(true)
                rv.layoutManager = LinearLayoutManager(activity)
                val rvAdapter = ReportAdapter(response.body()!!.data.report)
                rv.adapter = rvAdapter
            }

            override fun onFailure(call: Call<ReportResponse>, t: Throwable) {
                Log.e("ProjectError", t.toString())
            }
        })
    }

    fun getReportByUser(view: View) {
        val token = SignInActivity.sessionManager.getString("TOKEN")
        val user_name = SignInActivity.sessionManager.getString("USERNAME")
        val id= SignInActivity.sessionManager.getInteger("ID")
        api.getReportByUser(id,token.toString()).enqueue(object : Callback<ReportResponse> {
            override fun onResponse(
                call: Call<ReportResponse>,
                response: Response<ReportResponse>
            ) {
                Log.d("ProdukData", response.body().toString())

                val rv = view.findViewById(R.id.rv_report) as RecyclerView

                rv.setHasFixedSize(true)
                rv.layoutManager = LinearLayoutManager(activity)
                val rvAdapter = ReportAdapter(response.body()!!.data.report)
                rv.adapter = rvAdapter
            }

            override fun onFailure(call: Call<ReportResponse>, t: Throwable) {
                Log.e("ProjectError", t.toString())
            }
        })
    }
}