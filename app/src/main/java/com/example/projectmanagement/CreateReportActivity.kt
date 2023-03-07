package com.example.projectmanagement

import android.annotation.SuppressLint
import android.content.Intent
import android.content.pm.PackageManager
import android.database.Cursor
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.provider.MediaStore
import android.util.Log
import android.widget.*
import androidx.appcompat.app.AppCompatActivity
import com.example.projectmanagement.api.ApiEndpoint
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.response.report.ReportResponsePost
import com.example.toko.response.produk.ProjectResponsePost
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File

class CreateReportActivity : AppCompatActivity() {

    private lateinit var etNota : EditText
    private lateinit var etDate : EditText
    private lateinit var txtJd:TextView
    private  lateinit var etTime:EditText
    private lateinit var etPma: EditText
    private lateinit var etMember: EditText
    private lateinit var etProject: EditText
    private lateinit var btPick:ImageButton
    private lateinit var imgResult : ImageView
    private lateinit var btCreateReport : Button

    private var mediaPath:String? = null
    private var postPath:String? = null
    private val api by lazy { BaseRetrofit().endpoint }
    private lateinit var mApiInterface: ApiEndpoint


    override fun onRequestPermissionsResult(requestCode: Int, permissions: Array<String>, grantResults: IntArray) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults)
        if (requestCode == REQUEST_WRITE_PERMISSION && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
            saveImageUpload()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_create_report)
        etNota = findViewById(R.id.etNota)
        etDate = findViewById(R.id.etDate)
        mApiInterface = BaseRetrofit().endpoint

        etTime = findViewById(R.id.etTime)
        etPma = findViewById(R.id.pmaa)
        imgResult = findViewById(R.id.imgResult)
        etMember = findViewById(R.id.member)
        txtJd = findViewById(R.id.textView4)
        etProject = findViewById(R.id.projectid)
        btPick = findViewById(R.id.btGallery)
        btCreateReport = findViewById(R.id.btnAddReport)
        btPick.setOnClickListener {
            val galleryIntent = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
            startActivityForResult(galleryIntent, REQUEST_PICK_PHOTO)

        }
        btCreateReport.setOnClickListener {
            requestPermission()
        }

    }
    private fun requestPermission() {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            requestPermissions(arrayOf(android.Manifest.permission.WRITE_EXTERNAL_STORAGE), REQUEST_WRITE_PERMISSION)
        } else {
            saveImageUpload()
        }
    }
    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (resultCode == RESULT_OK) {
            if (requestCode == REQUEST_PICK_PHOTO) {
                if (data != null) {
                    // Ambil Image Dari Galeri dan Foto
                    val selectedImage: Uri? = data.data
                    val filePathColumn = arrayOf(MediaStore.Images.Media.DATA)
                    val cursor: Cursor =
                        selectedImage?.let { contentResolver.query(it, filePathColumn, null, null, null) }!!
                    cursor.moveToFirst()
                    val columnIndex: Int = cursor.getColumnIndex(filePathColumn[0])
                    mediaPath = cursor.getString(columnIndex)
                    imgResult.setImageURI(data.data)
                    txtJd.setText(data.data.toString())
                    cursor.close()
                    postPath = mediaPath
                }
            }
        }
    }
    @SuppressLint("SuspiciousIndentation")
    private fun saveImageUpload(){
        if (mediaPath == null) {
            Toast.makeText(applicationContext, "Pilih gambar dulu, baru simpan ...!", Toast.LENGTH_LONG).show()
        } else {
            val imageFile = File(mediaPath)
            Log.d("cekimagename",  imageFile.toString())

            val reqBody = imageFile.asRequestBody("multipart/form-file".toMediaTypeOrNull())
            val partImage = MultipartBody.Part.createFormData("image", imageFile.name, reqBody)

        val postReportCall = mApiInterface.postReport(
            MultipartBody.Part.createFormData("image", imageFile.name, reqBody),
                etNota.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
                etDate.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
                etTime.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
                etProject.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
                etPma.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
                etMember.text.toString().toRequestBody("text/plain".toMediaTypeOrNull())


        )
                postReportCall.enqueue(object :Callback<ReportResponsePost>{
                    override fun onResponse(call: Call<ReportResponsePost>, response: Response<ReportResponsePost>) {
                        val moveIntent =  Intent(applicationContext,MainUserActivity::class.java)
//                        startActivity(moveIntent)
                        finish()
                    }
                    override fun onFailure(call: Call<ReportResponsePost>, t: Throwable) {
                        Log.d("RETRO", "ON FAILURE : " + t.message)
                        //Log.d("RETRO", "ON FAILURE : " + t.cause)
                        Toast.makeText(applicationContext, "Error, image", Toast.LENGTH_LONG).show()
                    }

                })
        //            api.postReport(partImage,
//                etNota.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
//                etDate.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
//                etTime.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
//etProject.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
//                etPma.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
//                etMember.toString().toRequestBody("text/plain".toMediaTypeOrNull())
//            ).enqueue(object :
//                Callback<ReportResponsePost> {
//                override fun onResponse(
//                    call: Call<ReportResponsePost>,
//                    response: Response<ReportResponsePost>
//                ) {
//                    val correct = response.body()!!.success
//                    if (correct) {
//                        Log.d("Tambah",response.body().toString())
//                        Toast.makeText(applicationContext,"Tambah Project Berhasil",Toast.LENGTH_LONG).show()
//                        val moveIntent =  Intent(applicationContext,MainUserActivity::class.java)
//                        startActivity(moveIntent)
//
//                    } else {
//                        // proses sign up gagal, tampilkan pesan error
//                        Toast.makeText(applicationContext,"Tambah Project Gagal",Toast.LENGTH_LONG).show()
//                        val moveIntent =  Intent(applicationContext, MainUserActivity::class.java)
//                        startActivity(moveIntent)
//
//                    }
//                }
//                override fun onFailure(call: Call<ReportResponsePost>, t: Throwable) {
//                    Log.e("SignUpError",t.toString())
//                }
//
//            })
        }


        }
    companion object {
//        const val REQUEST_CODE_IMAGE = 101
                private const val REQUEST_PICK_PHOTO = 1
        private const val REQUEST_WRITE_PERMISSION = 2
    }

}