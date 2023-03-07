package com.example.projectmanagement.adapter

import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.projectmanagement.DetailsProjectActivity
import com.example.projectmanagement.DetailsReportActivity
import com.example.projectmanagement.R
import com.example.projectmanagement.SignInActivity
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.report.Report
import com.squareup.picasso.Picasso

class ReportAdapter (private  val listReport: List<Report>): RecyclerView.Adapter<ReportAdapter.ViewHolder>() {
    private  val api by lazy { BaseRetrofit().endpoint }


    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_report, parent, false)
        return ReportAdapter.ViewHolder(view)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val report = listReport[position]

        holder.namaProject.text = report.project_name
        holder.dateReport.text = report.report_date
        Picasso.with(holder.itemView.context).load("http://192.168.66.247/api-gmp/assets_style/image/report/"+report.report_nota).into(holder.imgReport);

        holder.btnDetail.setOnClickListener {

            val intent = Intent(holder.itemView.context, DetailsReportActivity::class.java)
            intent.putExtra("progress", report.report_progress)
            intent.putExtra("name", report.project_name)
            intent.putExtra("date", report.report_date)
            intent.putExtra("time", report.report_time)
            intent.putExtra("project",report.project_name)
            intent.putExtra("nota",report.report_nota)
            intent.putExtra("ket_nota",report.ket_nota)
            intent.putExtra("ket_progress",report.ket_progress)

            holder.itemView.context.startActivity(intent)
        }


        SignInActivity.sessionManager.getString("TOKEN")
        val token= SignInActivity.sessionManager    }

    override fun getItemCount(): Int {
        return listReport.size
    }



    class ViewHolder(itemViem: View) : RecyclerView.ViewHolder(itemViem) {
        val namaProject = itemViem.findViewById(R.id.nama_project) as TextView
        val dateReport = itemViem.findViewById(R.id.report_date) as TextView
        val imgReport = itemViem.findViewById(R.id.img_report) as ImageView
        val btnDetail = itemViem.findViewById(R.id.btn_detailReport) as ImageView

    }
}