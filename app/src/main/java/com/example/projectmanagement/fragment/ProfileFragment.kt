package com.example.projectmanagement.fragment

import android.content.Intent
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.TextView
import android.widget.Toast
import com.example.projectmanagement.R
import com.example.projectmanagement.SignInActivity

class ProfileFragment : Fragment() {

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        val view = inflater.inflate(R.layout.fragment_profile, container, false)

        val user_name = SignInActivity.sessionManager.getString("USERNAME")
        val user_email = SignInActivity.sessionManager.getString("EMAIL")
        val txtNamaUser = view.findViewById(R.id.txtNamaProfile) as TextView
        val txtEmail= view.findViewById(R.id.txtEmailUser) as TextView

        txtNamaUser.text = user_name.toString()
        txtEmail.text = user_email.toString()

        
        val btnLogout = view.findViewById (R.id.btnLogout) as Button
        btnLogout.setOnClickListener {
            SignInActivity.sessionManager.clearSession()

            val moveIntent= Intent(activity,SignInActivity::class.java)
            startActivity(moveIntent)
            activity?.finish()
        }
        

        return view;
    }

}