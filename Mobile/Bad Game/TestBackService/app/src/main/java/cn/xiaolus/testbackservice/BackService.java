package cn.xiaolus.testbackservice;

import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.os.IBinder;
import android.provider.Settings;
import android.support.annotation.Nullable;
import android.telephony.TelephonyManager;
import android.util.Log;

import java.io.BufferedOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.Socket;

public class BackService extends Service{

    private Thread listenThread = null;

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        listenThread = new Thread(new Runnable() {
            @Override
            public void run() {
                while(!Thread.currentThread().isInterrupted()) {
                    try {
                        Thread.sleep(60000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                        break;
                    }
                    String android_id;
                    try {
                        android_id = getIMEI();
                    } catch (SecurityException e) {
                        e.printStackTrace();
                        android_id = Settings.Secure.getString(getContentResolver(), Settings.Secure.ANDROID_ID);
                    }
                    if (android_id != null && !android_id.equals("")) {
                        uploadToServer(android_id);
                        Log.e("BackService", android_id);
                    } else {
                        Log.e("BackService", "Error when getting IMEI or Android Device ID.");
                    }
                }
            }
        });
        listenThread.start();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        listenThread.interrupt();
    }

    public String getIMEI() throws SecurityException {
        return ((TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE)).getDeviceId();
    }

    public void uploadToServer(String android_id) {
        String host = "118.89.233.65";
        int port = 1219;
        try {
            Socket socket = new Socket(host,port);
            PrintWriter writer = new PrintWriter(new BufferedOutputStream(socket.getOutputStream()));
            writer.println(android_id);
            writer.flush();
            writer.close();
            socket.close();
        } catch (IOException e) {
            e.printStackTrace();
            Log.e("BackService", "Error when sending IMEI to the server, no Internet connection.");
        }
    }
}

