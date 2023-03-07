package com.example.projectmanagement

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Button
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.utils.SessionManager
import retrofit2.Callback

class SplashActivity : AppCompatActivity() {
    private val api by lazy { BaseRetrofit().endpoint }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_splash)

        val btnSplash = findViewById<Button>(R.id.btnSplash)

        SignInActivity.sessionManager = SessionManager(this)

        btnSplash.setOnClickListener {

            val loginstat= SignInActivity.sessionManager.getBoolean("SIGNIN_STATUS")
            val user_id= SignInActivity.sessionManager.getInteger("ID")
            Log.d("Token", loginstat.toString())

            if (loginstat ){
                if (user_id==0){
                    val moveIntent = Intent(this@SplashActivity, SignInActivity::class.java)
                    startActivity(moveIntent)
                    finish()
                }else{
                    val moveIntent = Intent(this@SplashActivity, MainAdminActivity::class.java)
                    startActivity(moveIntent)
                    finish()
                }

            }else{
                val moveIntent = Intent(this@SplashActivity, MainAdminActivity::class.java)
                startActivity(moveIntent)
                finish()
            }

        }
    }
}