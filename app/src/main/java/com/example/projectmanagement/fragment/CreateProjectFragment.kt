package com.example.projectmanagement.fragment

import android.app.Activity
import android.app.Activity.RESULT_OK
import android.app.DatePickerDialog
import android.content.ContentResolver
import android.content.Intent
import android.content.pm.PackageManager
import android.net.Uri
import android.os.Build
import android.os.Bundle
import android.provider.MediaStore
import android.provider.OpenableColumns
import android.util.Config
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.*
import androidx.constraintlayout.widget.ConstraintLayout
import androidx.fragment.app.Fragment
import com.example.projectmanagement.MainUserActivity
import com.example.projectmanagement.R
import com.example.projectmanagement.SignInActivity
import com.example.projectmanagement.api.BaseRetrofit
import com.example.projectmanagement.init.UploadRequestBody
import com.example.projectmanagement.response.member.MemberResponse
import com.example.projectmanagement.response.pic.PicResponse
import com.example.toko.response.produk.ProjectResponsePost
import okhttp3.MediaType
import okhttp3.MediaType.Companion.toMediaTypeOrNull
import okhttp3.MultipartBody
import okhttp3.RequestBody
import okhttp3.RequestBody.Companion.asRequestBody
import okhttp3.RequestBody.Companion.toRequestBody
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.FileInputStream
import java.io.FileOutputStream
import java.util.*

 class CreateProjectFragment : Fragment(), UploadRequestBody.UploadCallback  {
    private var selectedImage: Uri? = null
    private var selectedId: String? = null
     private var selectedMember: String? = null
     private var mediaPath: String? = null
     private var postPath: String? = null

    private val api by lazy { BaseRetrofit().endpoint }

    lateinit var imagePic:ImageView
    private var picNameList = ArrayList<String>()
     private var memberList = ArrayList<String>()

    private var selectedImageUri: Uri? = null



    lateinit var etDesc:EditText
    lateinit var tx:TextView

    lateinit var etMember:EditText
    lateinit var etName:EditText
    lateinit var etImg:EditText
    lateinit var etStartDate:EditText
    lateinit var etEndDate:EditText

     override fun onRequestPermissionsResult(requestCode: Int, permissions: Array<String>, grantResults: IntArray) {
         if (requestCode == REQUEST_WRITE_PERMISSION && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
             upload()
         }
     }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        val view = inflater.inflate(R.layout.fragment_create_project, container, false)
        Log.d("tes",selectedImage.toString())

        val btImage = view.findViewById(R.id.btImage) as ImageButton
        val btnCreate = view.findViewById(R.id.btnCreateProject) as Button
        etDesc = view.findViewById(R.id.etDescription) as EditText
        imagePic = view.findViewById(R.id.imgPick) as ImageView
        etName = view.findViewById(R.id.etProjectName) as EditText
        etImg = view.findViewById(R.id.etPic) as EditText
        tx  = view.findViewById(R.id.textView4) as TextView
        val constran1= view.findViewById(R.id.cl_1) as ConstraintLayout
        val constran2= view.findViewById(R.id.cl_2) as ConstraintLayout

        etStartDate = view.findViewById(R.id.etStartDate) as EditText
        etEndDate = view.findViewById(R.id.etEndDate) as EditText

        imagePic.setOnClickListener{
            val galleryIntent = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
            startActivityForResult(galleryIntent, REQUEST_CODE_IMAGE)
        }

        val btnStartDate = view.findViewById(R.id.imageButton2) as ImageButton
        val btnEndDate = view.findViewById(R.id.imageButton3) as ImageButton

        btnStartDate.setOnClickListener {
            val c = Calendar.getInstance()
            val year = c.get(Calendar.YEAR)
            val month = c.get(Calendar.MONTH)
            val day = c.get(Calendar.DAY_OF_MONTH)
            val datePickerDialog = DatePickerDialog(
                requireContext(),
                { view, year, monthOfYear, dayOfMonth ->
                    val dat = (dayOfMonth.toString() + "-" + (monthOfYear + 1) + "-" + year)
                    etStartDate.setText(dat)

                },
                year,
                month,
                day
            )
            datePickerDialog.show()
        }
        imagePic.setImageURI(selectedImage)

        btnEndDate.setOnClickListener {
            val c = Calendar.getInstance()
            val year = c.get(Calendar.YEAR)
            val month = c.get(Calendar.MONTH)
            val day = c.get(Calendar.DAY_OF_MONTH)
            val datePickerDialog = DatePickerDialog(
                requireContext(),
                { view, year, monthOfYear, dayOfMonth ->
                    val dat = (dayOfMonth.toString() + "-" + (monthOfYear + 1) + "-" + year)
                    etEndDate.setText(dat)
Log.d("tanggal",dat)
                },
                year,
                month,
                day
            )

            datePickerDialog.show()
        }


        btnCreate.setOnClickListener {
            requestPermission()


        }
        getPic(view)
        getMember(view)

        val role= SignInActivity.sessionManager.getString("ROLE")
        Log.d("Cek Role", role.toString())

        if(role=="ADMIN"){
            constran2.setVisibility(View.GONE)
        } else {

          constran1.setVisibility(View.GONE)

        }

        return view;
    }
    companion object {
        const val REQUEST_CODE_IMAGE = 101
        private const val REQUEST_WRITE_PERMISSION = 2
    }



    private fun openImageChooser() {

            val galleryIntent = Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI)
            startActivityForResult(galleryIntent, REQUEST_CODE_IMAGE)
        }


     override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
         super.onActivityResult(requestCode, resultCode, data)

         if (resultCode == RESULT_OK) {
             if (requestCode == REQUEST_CODE_IMAGE) {
                 data?.data?.let { selectedImage ->
                     val filePathColumn = arrayOf(MediaStore.Images.Media.DATA)
                     val contentResolver = context?.contentResolver
                     contentResolver?.query(selectedImage, filePathColumn, null, null, null)?.use { cursor ->
                         cursor.moveToFirst()
                         val columnIndex = cursor.getColumnIndex(filePathColumn[0])
                         mediaPath = cursor.getString(columnIndex)
                         imagePic.setImageURI(selectedImage)
                         postPath = mediaPath
                     }
                 }
             }
         }
     }


//    private fun ContentResolver.getFileName(selectedImageUri: Uri): String {
//        var name = ""
//        val returnCursor = this.query(selectedImageUri,null,null,null,null)
//        if (returnCursor!=null){
//            val nameIndex = returnCursor.getColumnIndex(OpenableColumns.DISPLAY_NAME)
//            returnCursor.moveToFirst()
//            name = returnCursor.getString(nameIndex)
//            returnCursor.close()
//        }
//
//        return name
//    }

//
    private  fun upload(){

//    Log.d("Start Date", etStartDate.text.toString())
//    val token = SignInActivity.sessionManager.getString("TOKEN")
//
//    if (selectedImageUri == null) {
//        Toast.makeText(requireContext(), "Select an Image", Toast.LENGTH_SHORT).show()
//
//    }
//
//    val parcelFileDescriptor = context?.contentResolver?.openFileDescriptor(
//        selectedImageUri!!, "r", null
//    ) ?: return
//
//    val inputStream = FileInputStream(parcelFileDescriptor.fileDescriptor)
//    val file = File(context?.cacheDir, context?.contentResolver?.getFileName(selectedImageUri!!))
//
//    val reqBody= RequestBody.create("multipart/form-file".toMediaTypeOrNull(),file)
//    val partImage= MultipartBody.Part.createFormData("image",file.name,reqBody)
//
//    val outputStream = FileOutputStream(file)
//    inputStream.copyTo(outputStream)
//
    tx.setText(mediaPath.toString())
//    val body = UploadRequestBody(file, "image", this)
    Toast.makeText(context, "dsadasqqqqqq", Toast.LENGTH_SHORT).show()

    if (mediaPath == null) {
        Toast.makeText(context, "Pilih gambar dulu, baru simpan ...!", Toast.LENGTH_LONG).show()
    } else {
        val imageFile = File(mediaPath!!)
        val reqBody = imageFile.asRequestBody("multipart/form-file".toMediaTypeOrNull())
        val partImage = MultipartBody.Part.createFormData("image", imageFile.name, reqBody)

//
    api.postProject(
        etName.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
        etStartDate.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
        etEndDate.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
        etDesc.text.toString().toRequestBody("text/plain".toMediaTypeOrNull()),partImage,
        selectedId!!.toString().toRequestBody("text/plain".toMediaTypeOrNull()),
        selectedMember!!.toString().toRequestBody("text/plain".toMediaTypeOrNull())
    ).enqueue(object :
        Callback<ProjectResponsePost> {
        override fun onResponse(
            call: Call<ProjectResponsePost>,
            response: Response<ProjectResponsePost>
        ) {
            val correct = response.body()!!.success
            if (correct) {
                Log.d("Tambah",response.body().toString())
                Toast.makeText(requireContext(),"Tambah Project Berhasil",Toast.LENGTH_LONG).show()
                val moveIntent =  Intent(requireContext(),MainUserActivity::class.java)
                startActivity(moveIntent)

            } else {
                // proses sign up gagal, tampilkan pesan error
                Toast.makeText(requireContext(),"Tambah Project Gagal",Toast.LENGTH_LONG).show()
                val moveIntent =  Intent(requireContext(), MainUserActivity::class.java)
                startActivity(moveIntent)

            }
        }
        override fun onFailure(call: Call<ProjectResponsePost>, t: Throwable) {
            Log.e("SignUpError",t.toString())
        }

    })
    }
    }




     fun getMember(view: View){
         val token = SignInActivity.sessionManager.getString("TOKEN")
         api.getMember(token.toString()).enqueue(object : Callback<MemberResponse> {
             override fun onResponse(
                 call: Call<MemberResponse>,
                 response: Response<MemberResponse>
             ) {
                 Log.d("memberData", response.body().toString())
                 val memberResponse = response.body()
                 for (user in memberResponse!!.data.user) {
                     memberList.add(user.user_name)
//                    picNameList.add(pic.pic_id)
                 }
                 Log.d("tpp",picNameList.toString())
                 val spinnermember = view.findViewById(R.id.spinnerMember) as Spinner

                 val adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, memberList)
                 spinnermember.adapter = adapter
                 spinnermember.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
                     override fun onItemSelected(
                         parent: AdapterView<*>?,
                         view: View?,
                         position: Int,
                         id: Long
                     ) {

                         val selectedValue = parent?.getItemAtPosition(position).toString()
                         for (user in memberResponse!!.data.user) {
                             if (user.user_name == selectedValue) {
                                 selectedMember = user.user_id

                                 Log.d("id",selectedValue.toString())
                                 Log.d("id",selectedMember.toString())
                                 break
                             }
                         }
                     }

                     override fun onNothingSelected(parent: AdapterView<*>?) {

                     }
                 }

             }

             override fun onFailure(call: Call<MemberResponse>, t: Throwable) {
                 Log.e("ProjectError", t.toString())
             }
         })

     }
    fun getPic(view: View) {
        val token = SignInActivity.sessionManager.getString("TOKEN")
        api.getPic(token.toString()).enqueue(object : Callback<PicResponse> {
            override fun onResponse(
                call: Call<PicResponse>,
                response: Response<PicResponse>
            ) {
                Log.d("picData", response.body().toString())
                val picResponse = response.body()
                for (pic in picResponse!!.data.pic) {
                    picNameList.add(pic.pic_name)
//                    picNameList.add(pic.pic_id)
                }
                Log.d("tpp",picNameList.toString())
                val spinner = view.findViewById(R.id.Etspinner) as Spinner

                val adapter = ArrayAdapter(requireContext(), android.R.layout.simple_spinner_item, picNameList)
                spinner.adapter = adapter
                        spinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
                            override fun onItemSelected(
                                parent: AdapterView<*>?,
                                view: View?,
                                position: Int,
                                id: Long
                            ) {

                                val selectedValue = parent?.getItemAtPosition(position).toString()
                                for (pic in picResponse!!.data.pic) {
                                    if (pic.pic_name == selectedValue) {
                                        selectedId = pic.pic_id

                                        Log.d("id",selectedValue.toString())
                                        Log.d("id",selectedId.toString())
                                        break
                                    }
                                }
                            }

                            override fun onNothingSelected(parent: AdapterView<*>?) {

                            }
                        }

            }

            override fun onFailure(call: Call<PicResponse>, t: Throwable) {
                Log.e("ProjectError", t.toString())
            }
        })
    }
     // Check Android Version to Request Permission
     private fun requestPermission() {
         if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
             requestPermissions(arrayOf(android.Manifest.permission.WRITE_EXTERNAL_STORAGE), REQUEST_WRITE_PERMISSION)
         } else {
             Toast.makeText(context, "dfssdf", Toast.LENGTH_SHORT).show()

             upload()
         }
     }
     override val contentResolver: Any
         get() = TODO("Not yet implemented")

     override fun onProgressUpdate(percentage: Int) {
         TODO("Not yet implemented")
     }
 }