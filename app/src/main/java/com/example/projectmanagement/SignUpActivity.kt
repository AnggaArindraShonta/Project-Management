package com.example.projectmanagement

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.signup.SignUpResponse
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class SignUpActivity : AppCompatActivity() {
    private val api by lazy { BaseRetrofit().endpoint }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_sign_up)

        val btnSignUp = findViewById<Button>(R.id.btnSignUp)
        val etNama = findViewById<EditText>(R.id.etNama)
        val etEmail = findViewById<EditText>(R.id.etEmail)
        val etPassword = findViewById<EditText>(R.id.etPassword)
        val rbEngineering = findViewById<RadioButton>(R.id.rbEngineering)
        val rbLogistic = findViewById<RadioButton>(R.id.rbLogistic)
        val tvSignIn = findViewById<TextView>(R.id.tvSignIn)

        tvSignIn.setOnClickListener {
            val moveIntent =  Intent(this@SignUpActivity,SignInActivity::class.java)
            startActivity(moveIntent)
            finish()
        }

        var role_id: String = ""
        rbEngineering.setOnCheckedChangeListener { buttonView, isChecked ->
            if (isChecked) {
                role_id = "2"
            }
        }

        rbLogistic.setOnCheckedChangeListener { buttonView, isChecked ->
            if (isChecked) {
                role_id = "3"
            }
        }

        btnSignUp.setOnClickListener{

            Toast.makeText(this, "Proses Register", Toast.LENGTH_SHORT).show()

            api.SignUp(etNama.text.toString(),etEmail.text.toString(),etPassword.text.toString(), role_id).enqueue(object :
                Callback<SignUpResponse> {
                override fun onResponse(
                    call: Call<SignUpResponse>,
                    response: Response<SignUpResponse>
                ) {
                    val correct = response.body()!!.success
                    if (correct) {
                        Toast.makeText(applicationContext,"Proses Register Berhasil",Toast.LENGTH_LONG).show()
                        val moveIntent =  Intent(this@SignUpActivity,SignInActivity::class.java)
                        startActivity(moveIntent)
                        finish()
                    } else {
                        // proses sign up gagal, tampilkan pesan error
                        Toast.makeText(applicationContext,"Proses Register Gagal",Toast.LENGTH_LONG).show()
                        val moveIntent =  Intent(this@SignUpActivity,SignUpActivity::class.java)
                        startActivity(moveIntent)
                        finish()
                    }
                }
                override fun onFailure(call: Call<SignUpResponse>, t: Throwable) {
                    Log.e("SignUpError",t.toString())
                }

            })
        }

    }
}