package com.example.projectmanagement

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import android.widget.TextView
import android.widget.Toast
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.signin.SignInResponse
import com.example.projectmanagement.utils.SessionManager
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class SignInActivity : AppCompatActivity() {
    private val api by lazy { BaseRetrofit().endpoint }

    companion object {
        lateinit var sessionManager: SessionManager
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_sign_in)

        sessionManager = SessionManager(this)

        val loginStatus = sessionManager.getBoolean("SIGNIN_STATUS")
//        loginStatus.saveBoolean("LOGIN_STATUS",true)
        Log.d("session", loginStatus.toString())
        if(loginStatus){
            val moveIntent =  Intent(this@SignInActivity,MainAdminActivity::class.java)
            startActivity(moveIntent)
            finish()
            val role = sessionManager.getString("ROLE")
            if(role == "ADMIN") {
                // Jika role bernilai 1, maka user login sebagai admin
                sessionManager.saveString("ROLE","ADMIN")
                Toast.makeText(applicationContext,"Anda login sebagai Admin",Toast.LENGTH_LONG).show()
                val moveIntent =  Intent(this@SignInActivity,MainAdminActivity::class.java)
                startActivity(moveIntent)
                finish()
            } else if (role == "ENGINEER") {
                // Jika role bernilai 2, maka user login sebagai user biasa
                sessionManager.saveString("ROLE","USER")
                Toast.makeText(applicationContext,"Anda login sebagai Engineer",Toast.LENGTH_LONG).show()
                val moveIntent =  Intent(this@SignInActivity,MainUserActivity::class.java)
                startActivity(moveIntent)
                finish()
            } else if (role == "LOGISTIC") {
                // Jika role bernilai 3, maka user login sebagai user biasa
                sessionManager.saveString("ROLE","USER")
                Toast.makeText(applicationContext,"Anda login sebagai Logistic",Toast.LENGTH_LONG).show()
                val moveIntent =  Intent(this@SignInActivity,MainUserActivity::class.java)
                startActivity(moveIntent)
                finish()
            }
        }else{
            Toast.makeText(applicationContext,"Anda Belum Login",Toast.LENGTH_LONG).show()

        }

        val btnSignIn = findViewById<Button>(R.id.btnSignIn)
        val etNama = findViewById<EditText>(R.id.etNama)
        val etEmail = findViewById<EditText>(R.id.etEmail)
        val etPassword = findViewById<EditText>(R.id.etPassword)
        val tvSignUp = findViewById<TextView>(R.id.tvSignUp)

        tvSignUp.setOnClickListener {
            val moveIntent =  Intent(this@SignInActivity,SignUpActivity::class.java)
            startActivity(moveIntent)
            finish()
        }

        btnSignIn.setOnClickListener{
            Toast.makeText(this, "Proses Login", Toast.LENGTH_SHORT).show()

            api.SignIn(etNama.text.toString(),etEmail.text.toString(),etPassword.text.toString()).enqueue(object :
                Callback<SignInResponse> {
                override fun onResponse(
                    call: Call<SignInResponse>,
                    response: Response<SignInResponse>
                ) {
                    val correct = response.body()!!.success
                    if(correct){
                        //untuk menyimpan session dengan mendapatkan data token dari response body
                        val  token = response.body()!!.data.token
                        val nameuser= response.body()!!.data.user.user_name
                        val role = response.body()!!.data.user.role_id
                        val email= response.body()!!.data.user.user_email

                        sessionManager.saveString("USERNAME", nameuser)
                        sessionManager.saveString("EMAIL",email)
                        sessionManager.saveString("TOKEN","Bearer " + token)
                        sessionManager.saveBoolean("LOGIN_STATUS",true)
                        sessionManager.saveString("ROLE",role)
                        sessionManager.saveInteger("ID",response.body()!!.data.user.user_id.toInt())
                        Toast.makeText(this@SignInActivity, "Selamat Datang "+nameuser, Toast.LENGTH_SHORT).show()
                        if(role == "1") {
                            // Jika role bernilai 1, maka user login sebagai admin
                            sessionManager.saveString("ROLE","ADMIN")
                            Toast.makeText(applicationContext,"Anda login sebagai Admin",Toast.LENGTH_LONG).show()
                            val moveIntent =  Intent(this@SignInActivity,MainAdminActivity::class.java)
                            startActivity(moveIntent)
                            finish()
                        } else if (role == "2") {
                            // Jika role bernilai 2, maka user login sebagai user biasa
                            sessionManager.saveString("ROLE","USER")
                            Toast.makeText(applicationContext,"Anda login sebagai Engineer",Toast.LENGTH_LONG).show()
                            val moveIntent =  Intent(this@SignInActivity,MainUserActivity::class.java)
                            startActivity(moveIntent)
                            finish()
                        } else if (role == "3") {
                            // Jika role bernilai 3, maka user login sebagai user biasa
                            sessionManager.saveString("ROLE","USER")
                            Toast.makeText(applicationContext,"Anda login sebagai Logistic",Toast.LENGTH_LONG).show()
                            val moveIntent =  Intent(this@SignInActivity,MainUserActivity::class.java)
                            startActivity(moveIntent)
                            finish()
                        }
                    }else{
                        Toast.makeText(applicationContext,"Data ada yang salah", Toast.LENGTH_LONG).show()
                    }
                    Log.d("Data User",response.body().toString())
                }
                override fun onFailure(call: Call<SignInResponse>, t: Throwable) {
                    Log.e("SignInError",t.toString())
                }

            })
        }
    }
}