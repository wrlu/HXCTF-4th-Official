package cn.xiaolus.hxctf.crypto.pkcs12;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.security.KeyStore;
import java.security.SecureRandom;
import java.security.KeyStore.SecretKeyEntry;
import java.util.Base64;

import javax.crypto.Cipher;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;

public class GenMain {

	public static void main(String[] args) throws Exception {
		KeyStore ks = KeyStore.getInstance("PKCS12");
		ks.load(new FileInputStream("PKCS12.keystore"), "admin123".toCharArray());
		KeyStore.ProtectionParameter protParam = new KeyStore.PasswordProtection("admin123".toCharArray());
		KeyStore.SecretKeyEntry keyEntry = (SecretKeyEntry)ks.getEntry("key", protParam);
		SecretKey key = keyEntry.getSecretKey();
		FileOutputStream encFos = new FileOutputStream("flag.enc");
		SecureRandom random = new SecureRandom();
		byte[] bytes = new byte[16];
		random.nextBytes(bytes);
		
		IvParameterSpec iv = new IvParameterSpec(bytes);
		Cipher cipher = Cipher.getInstance("AES/OFB/PKCS5Padding");
		cipher.init(Cipher.ENCRYPT_MODE, key, iv);
		byte[] enc = cipher.doFinal("HXCTF{Weak_PWD_Make_Key_Unsecure}".getBytes());
		
		encFos.write("Mode=AES/OFB/PKCS5Padding\r\nIV=".getBytes());
		encFos.write(Base64.getEncoder().encode(bytes));
		encFos.write("\r\nCiphertext=".getBytes());
		encFos.write(Base64.getEncoder().encode(enc));
		encFos.flush();
		encFos.close();
	}

}
