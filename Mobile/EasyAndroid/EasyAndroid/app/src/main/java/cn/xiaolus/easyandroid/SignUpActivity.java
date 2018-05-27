package cn.xiaolus.easyandroid;

import android.Manifest;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.sqlite.SQLiteDatabase;
import android.os.Build;
import android.os.Environment;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import java.io.File;
import java.security.MessageDigest;
import java.security.SecureRandom;

public class SignUpActivity extends AppCompatActivity {

    private SQLiteDatabase sqLiteDatabase;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signup);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            checkPermission();
        } else {
            solveDatabase();
        }
        final EditText usernameText = findViewById(R.id.editTextUsernameReg);
        final EditText passwordText = findViewById(R.id.editTextPasswordReg);
        final EditText passwordConfirm = findViewById(R.id.editTextPasswordConfirm);
        Button signupButton = findViewById(R.id.btnSignUpOk);
        signupButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (usernameText.getText().length()==0) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
                    alertDialog.setTitle("提示");
                    alertDialog.setMessage("请输入用户名");
                    alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    });
                    alertDialog.show();
                    Log.d("AdbControl","请输入用户名");
                    return;
                }
                if (passwordText.getText().length()==0) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
                    alertDialog.setTitle("提示");
                    alertDialog.setMessage("请输入密码");
                    alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    });
                    alertDialog.show();
                    Log.d("AdbControl","请输入密码");
                    return;
                }
                if (passwordConfirm.getText().length()==0) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
                    alertDialog.setTitle("提示");
                    alertDialog.setMessage("请再输入一次密码");
                    alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    });
                    alertDialog.show();
                    Log.d("AdbControl","请再输入一次密码");
                    return;
                }
                if (!passwordText.getText().toString().equals(passwordConfirm.getText().toString())) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
                    alertDialog.setTitle("提示");
                    alertDialog.setMessage("两次密码输入不一致，请重试");
                    alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                        }
                    });
                    alertDialog.show();
                    Log.d("AdbControl","两次密码输入不一致，请重试");
                    return;
                }
                addUser(usernameText.getText().toString(),passwordConfirm.getText().toString());
            }
        });
    }
    private void checkPermission() {
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.WRITE_EXTERNAL_STORAGE)
                != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this,new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE},0);
        } else {
            solveDatabase();
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (grantResults[0] == PackageManager.PERMISSION_GRANTED) {
            solveDatabase();
        } else {
            AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
            alertDialog.setTitle("未取得权限");
            alertDialog.setMessage("请允许存储空间权限，应用程序才能工作");
            alertDialog.setPositiveButton("退出", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    System.exit(1);
                }
            });
            alertDialog.show();
        }
    }

    private void solveDatabase() {
        File dir = new File(new StringBuilder(Environment.getExternalStorageDirectory().getAbsolutePath())
                .append("/HXCTF{welcome_to_use_/").toString());
        if (!Environment.getExternalStorageState().equals(Environment.MEDIA_MOUNTED)) {
            System.exit(1);
        }
        if (!dir.exists()) {
            dir.mkdir();
        }
        sqLiteDatabase = SQLiteDatabase.openOrCreateDatabase(new StringBuilder(dir.getAbsolutePath())
                .append("the_beautiful_android}.sqlite").toString(), null);
        sqLiteDatabase.execSQL("create table if not exists users( username varchar(32) primary key,passwordhash varchar(32),salt varchar(16));");
    }

    private void addUser(final String username,final String password) {
        try {
            MessageDigest messageDigest = MessageDigest.getInstance("SHA-256");
            SecureRandom secureRandom = new SecureRandom();
            String salt =  Long.toHexString(secureRandom.nextLong());
            String passwordHash = Base64.encodeToString(messageDigest.digest(new StringBuilder(password).append(salt).toString().getBytes()), Base64.DEFAULT);
            String sql = "insert into users values(?,?,?)";
            sqLiteDatabase.execSQL(sql, new String[]{ username, passwordHash, salt});

            AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignUpActivity.this);
            alertDialog.setTitle("提示");
            alertDialog.setMessage("注册成功");
            alertDialog.setPositiveButton("好", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Intent intent = new Intent(SignUpActivity.this,SignInActivity.class);
                    Bundle bundle = new Bundle();
                    bundle.putString("username",username);
                    bundle.putString("password",password);
                    startActivity(intent,bundle);
                    SignUpActivity.this.onDestroy();
                }
            });
            alertDialog.show();
        } catch (Exception e) {
            Toast.makeText(this,e.getLocalizedMessage(),Toast.LENGTH_SHORT);
            Log.d("AdbControl",e.getLocalizedMessage(),e);
            e.printStackTrace();
        }
    }
}