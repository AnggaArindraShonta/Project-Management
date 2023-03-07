package com.example.projectmanagement

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import androidx.navigation.findNavController
import androidx.navigation.ui.setupWithNavController
import com.google.android.material.bottomnavigation.BottomNavigationView

class MainUserActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main_user)

        val bottomNavigationViewa = findViewById<BottomNavigationView>(R.id.bottom_Nav2)
        val navControllers = findNavController(R.id.nav_fragment2)
        bottomNavigationViewa.setupWithNavController(navControllers)
    }
}