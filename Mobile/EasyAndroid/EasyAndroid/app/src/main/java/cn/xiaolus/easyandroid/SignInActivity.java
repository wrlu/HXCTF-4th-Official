package cn.xiaolus.easyandroid;

import android.Manifest;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
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

public class SignInActivity extends AppCompatActivity {

    private SQLiteDatabase sqLiteDatabase;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_signin);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
            checkPermission();
        } else {
            solveDatabase();
        }
        final EditText usernameText = findViewById(R.id.editTextUsernameReg);
        final EditText passwordText = findViewById(R.id.editTextPasswordReg);
        if (savedInstanceState != null) {
            usernameText.setText((String)savedInstanceState.get("username"));
            passwordText.setText((String)savedInstanceState.get("password"));
        }
        Button signinButton = findViewById(R.id.btnSignIn);
        signinButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (usernameText.getText().length()==0) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
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
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
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
                checkSignIn(usernameText.getText().toString(),passwordText.getText().toString());
            }
        });
        Button signupButton = findViewById(R.id.btnSignUp);
        signupButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(SignInActivity.this,SignUpActivity.class);
                startActivity(intent);
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
            AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
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

    private void checkSignIn(final String username,final String password) {
        try {
            String sql = "select * from users where username = ?";
            Cursor cursor = sqLiteDatabase.rawQuery(sql, new String[]{username});
            if (cursor.getCount() == 1) {
                cursor.moveToFirst();
                String salt = cursor.getString(2);
                MessageDigest messageDigest = MessageDigest.getInstance("SHA-256");
                String passwordHashInput = Base64.encodeToString(messageDigest.digest(new StringBuilder(password).append(salt).toString().getBytes()),Base64.DEFAULT);
                String passwordHashRight = cursor.getString(1);
                if (passwordHashInput.equals(passwordHashRight)) {
                    AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
                    alertDialog.setTitle("提示");
                    alertDialog.setMessage(new StringBuilder("尊敬的").append(username).append(":欢迎使用助航灯光管理系统"));
                    alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            Intent intent = new Intent(SignInActivity.this,MainActivity.class);
                            startActivity(intent);
                            SignInActivity.this.onDestroy();
                        }
                    });
                    alertDialog.show();
                } else {
                    Toast.makeText(this,"提示：用户名或密码错误",Toast.LENGTH_SHORT);
                    Log.d("AdbControl","提示：用户名或密码错误");
                }
            } else if (cursor.getCount() <= 0) {
                AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
                alertDialog.setTitle("错误提示");
                alertDialog.setMessage("错误：用户不存在");
                alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                    }
                });
                alertDialog.show();
                Log.d("AdbControl","错误：用户不存在");
            } else if (cursor.getCount() > 1){
                AlertDialog.Builder alertDialog = new AlertDialog.Builder(SignInActivity.this);
                alertDialog.setTitle("错误提示");
                alertDialog.setMessage("内部错误：用户重复");
                alertDialog.setPositiveButton("确定", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {

                    }
                });
                alertDialog.show();
                Log.d("AdbControl","内部错误：用户重复");
            }
        } catch (Exception e) {
            Toast.makeText(this,e.getLocalizedMessage(),Toast.LENGTH_SHORT);
            Log.d("AdbControl",e.getLocalizedMessage(),e);
            e.printStackTrace();
        }
    }
}