package com.example.projectmanagement.adapter
import android.content.Intent
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.core.content.ContextCompat.startActivity
import androidx.navigation.NavController
import androidx.navigation.findNavController
import androidx.recyclerview.widget.RecyclerView
import com.bumptech.glide.Glide
import com.example.projectmanagement.DetailsProjectActivity
import com.example.projectmanagement.R
import com.example.projectmanagement.SignInActivity
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.project.Project
import com.squareup.picasso.Picasso

class ProjectAdapter(private val listProject: List<Project>):RecyclerView.Adapter<ProjectAdapter.ViewHolder>() {

    private  val api by lazy { BaseRetrofit().endpoint }
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_project, parent, false)
        return ViewHolder(view)
    }

//    http://localhost/api-gmp/assets_style/image/projects/e702297cf3918f03a9c5e38da5d0c531.jpeg
    override fun onBindViewHolder(holder: ViewHolder, position: Int) {
        val project = listProject[position]
//        val imgUrl= "http://192.168.1.11/api-gmp/assets_style/image/projects/"
//        Glide.with(holder.itemView.context)
//                .load(""+project.project_picture)
//                .into(holder.imgProject)
    Picasso.with(holder.itemView.context).load("http://192.168.1.18/api-gmp/assets_style/image/projects/"+project.project_picture).into(holder.imgProject);
        holder.tvJudul.text = project.project_name
        holder.tvKet.text = project.project_description



        SignInActivity.sessionManager.getString("TOKEN")
        val token= SignInActivity.sessionManager
//        }
        holder.btnDetail.setOnClickListener {

            val intent = Intent(holder.itemView.context, DetailsProjectActivity::class.java)
            intent.putExtra("DESC", project.project_description)
            intent.putExtra("NAME", project.project_name)
            intent.putExtra("STARTDATE", project.start_date)
            intent.putExtra("ENDDATE", project.end_date)
            intent.putExtra("IDPROJECT",project.project_id)
            intent.putExtra("PIC",project.pic_name)
            intent.putExtra("PP",project.project_picture)
            intent.putExtra("MEMBER",project.member)

            holder.itemView.context.startActivity(intent)
        }
        }




    override fun getItemCount(): Int {
        return listProject.size
    }

    class ViewHolder(itemViem: View) : RecyclerView.ViewHolder(itemViem) {
        val imgProject = itemViem.findViewById(R.id.img_project) as ImageView
        val tvJudul = itemViem.findViewById(R.id.judul_project) as TextView
        val tvKet = itemViem.findViewById(R.id.ket_project) as TextView
        val btnDetail = itemViem.findViewById(R.id.btn_detail) as ImageView
    }
}