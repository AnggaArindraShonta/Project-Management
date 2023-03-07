package com.example.projectmanagement

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.ImageButton
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.navigation.findNavController
import com.example.projectmanagement.api.BaseRetrofit
import com.example.toko.response.produk.ProjectResponse
import com.squareup.picasso.Picasso
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class DetailsProjectActivity : AppCompatActivity() {

    private val api by lazy { BaseRetrofit().endpoint }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_details_project)

        val txtJudul = findViewById(R.id.detJudul) as TextView
        val projectpicture = findViewById(R.id.img_projects) as ImageView
        val txtDesc = findViewById(R.id.dtDesc) as TextView
        val startDate = findViewById(R.id.dtStartDate) as TextView
        val endDate = findViewById(R.id.dtEndDate) as TextView
        val txtPic = findViewById(R.id.txtPic) as TextView
        val txtMember= findViewById(R.id.txtMembe) as TextView
        val btnRemove= findViewById(R.id.button) as ImageButton

        val projectName = intent.getStringExtra("NAME")
        val projectDesc = intent.getStringExtra("DESC")
        val start = intent.getStringExtra("STARTDATE")
        val end = intent.getStringExtra("ENDDATE")
        val idProject= intent.getStringExtra("IDPROJECT")
        val  member= intent.getStringExtra("MEMBER")
        val pic = intent.getStringExtra("PIC")
        val pp = intent.getStringExtra("PP")

        val role= SignInActivity.sessionManager.getString("ROLE")
        val token= SignInActivity.sessionManager.getString("TOKEN")

        Log.d("Cek Role", role.toString())

        if(role=="ADMIN"){
            //setVisibility Gone


            btnRemove.setOnClickListener{
                api.deleteProject(token.toString(), idProject!!.toInt()).enqueue(object :
                    Callback<ProjectResponse> {
                    override fun onResponse(
                        call: Call<ProjectResponse>,
                        response: Response<ProjectResponse>
                    ) {
                        Log.d("Sucess", response.toString())

                        Toast.makeText(
                            applicationContext,
                            "Data Berhasil diHapus",
                            Toast.LENGTH_SHORT
                        ).show()
                        val moveIntent = Intent(this@DetailsProjectActivity, MainUserActivity::class.java)
                        startActivity(moveIntent)
                        finish()
//                        findNavController().navigate(R.id.produkFragment)
                    }

                    override fun onFailure(call: Call<ProjectResponse>, t: Throwable) {

                        val moveIntent = Intent(this@DetailsProjectActivity, MainUserActivity::class.java)
                        startActivity(moveIntent)
                        finish()
                    }

                })

            }

        } else {
            btnRemove.setVisibility(View.GONE);




        }

        txtJudul.setText(projectName)
        txtDesc.setText(projectDesc)
        startDate.setText(start)
        endDate.setText(end)
        txtMember.setText(member)

        Picasso.with(applicationContext).load("http://192.168.1.18/api-gmp/assets_style/image/projects/"+pp).into(projectpicture);
        txtPic.setText(pic)
    }
}