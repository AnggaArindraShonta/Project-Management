package com.example.projectmanagement.fragment

import android.annotation.SuppressLint
import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.projectmanagement.*
import com.example.projectmanagement.adapter.ProjectAdapter
import com.example.projectmanagement.api.BaseRetrofit
import com.example.toko.response.produk.ProjectResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class HomeFragment : Fragment() {

    private val api by lazy { BaseRetrofit().endpoint }

    @SuppressLint("SuspiciousIndentation")
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        val view = inflater.inflate(R.layout.fragment_home, container, false)

      val role= SignInActivity.sessionManager.getString("ROLE")
        Log.d("Cek Role", role.toString())

        if(role=="ADMIN"){

            getAllProject(view)
        } else {


            getProject(view)

        }

        return view;
    }

        //memanggil produk dari api
        fun getProject(view: View) {
            val token = SignInActivity.sessionManager.getString("TOKEN")
            val user_name = SignInActivity.sessionManager.getString("USERNAME")
            val id= SignInActivity.sessionManager.getInteger("ID")
            api.getProjectMember(id,token.toString()).enqueue(object : Callback<ProjectResponse> {
                override fun onResponse(
                    call: Call<ProjectResponse>,
                    response: Response<ProjectResponse>
                ) {
                    val  pesan = response.body()!!.message
                    if (pesan== "Token tidak valid"){
                        val intent = Intent(activity, SignInActivity::class.java)
                        intent.flags = Intent.FLAG_ACTIVITY_CLEAR_TASK or Intent.FLAG_ACTIVITY_NEW_TASK
                        startActivity(intent)
//                        finish()
                    }else {


                        Log.d("ProdukData", response.body().toString())

                        val rv = view.findViewById(R.id.rv_project) as RecyclerView
                        val txtNamaUser = view.findViewById(R.id.txtNamaUser) as TextView

                        txtNamaUser.text = user_name.toString()

                        rv.setHasFixedSize(true)
                        rv.layoutManager = LinearLayoutManager(activity)
                        val rvAdapter = ProjectAdapter(response.body()!!.data.project)
                        rv.adapter = rvAdapter
                    }
                }

                override fun onFailure(call: Call<ProjectResponse>, t: Throwable) {
                    Log.e("ProjectError", t.toString())
                }
            })
        }
    //memanggil produk dari api
    fun getAllProject(view: View) {
        val token = SignInActivity.sessionManager.getString("TOKEN")
        val user_name = SignInActivity.sessionManager.getString("USERNAME")
        api.getProject(token.toString()).enqueue(object : Callback<ProjectResponse> {
            override fun onResponse(
                call: Call<ProjectResponse>,
                response: Response<ProjectResponse>
            ) {
                Log.d("ProdukData", response.body().toString())

                val rv = view.findViewById(R.id.rv_project) as RecyclerView
                val txtNamaUser = view.findViewById(R.id.txtNamaUser) as TextView

                txtNamaUser.text = user_name.toString()

                rv.setHasFixedSize(true)
                rv.layoutManager = LinearLayoutManager(activity)
                val rvAdapter = ProjectAdapter(response.body()!!.data.project)
                rv.adapter = rvAdapter
            }

            override fun onFailure(call: Call<ProjectResponse>, t: Throwable) {
                Log.e("ProjectError", t.toString())
            }
        })
    }

}
