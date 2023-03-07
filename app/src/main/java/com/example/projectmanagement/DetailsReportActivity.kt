package com.example.projectmanagement

import android.media.Image
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.ImageView
import android.widget.TextView
import com.example.projectmanagement.api.BaseRetrofit
import com.squareup.picasso.Picasso

class DetailsReportActivity : AppCompatActivity() {

    private val api by lazy { BaseRetrofit().endpoint }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_details_report)

       val namaproject = findViewById(R.id.projectname) as TextView
        val progress = findViewById(R.id.progress) as ImageView
        val nota = findViewById(R.id.nota) as ImageView
        val date = findViewById(R.id.dateReport) as TextView
        val time = findViewById(R.id.timeReport) as TextView
        val det_ket_nota = findViewById(R.id.det_ket_nota) as TextView
        val det_ket_progress = findViewById(R.id.det_ket_progress) as TextView

        val namaproj = intent.getStringExtra("name")
        val imgprogress = intent.getStringExtra("progress")
        val datereport = intent.getStringExtra("date")
        val timereport = intent.getStringExtra("time")
        val imgnota = intent.getStringExtra("nota")
        val ket_nota = intent.getStringExtra("ket_nota")
        val ket_progress = intent.getStringExtra("ket_progress")

        namaproject.setText(namaproj)
        date.setText(datereport)
        time.setText(timereport)
        det_ket_nota.setText(ket_nota)
        det_ket_progress.setText(ket_progress)
        Picasso.with(applicationContext).load("http://192.168.66.247/api-gmp/assets_style/image/report/$imgprogress").into(progress);
        Picasso.with(applicationContext).load("http://192.168.66.247/api-gmp/assets_style/image/report/$imgnota").into(nota);



    }
}