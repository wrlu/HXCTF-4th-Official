package cn.xiaolus.hxctf.crypto.pkcs12;

import java.io.FileInputStream;
import java.security.KeyStore;
import java.security.KeyStore.SecretKeyEntry;
import java.util.Base64;
import java.util.Scanner;

import javax.crypto.Cipher;
import javax.crypto.SecretKey;
import javax.crypto.spec.IvParameterSpec;

public class WriteupMain {

	public static void main(String[] args) throws Exception {
		String password = "";
		Scanner dic = new Scanner(new FileInputStream("english.dic"));
		KeyStore ks = KeyStore.getInstance("PKCS12");
		while(dic.hasNextLine()) {
			password = dic.nextLine();
			try {
				System.out.println(password);
				ks.load(new FileInputStream("PKCS12.keystore"), password.toCharArray());
				System.out.println(password);
				break;
			} catch (Exception e) {
				continue;
			}
		}
		dic.close();
		KeyStore.ProtectionParameter protParam = new KeyStore.PasswordProtection(password.toCharArray());
		KeyStore.SecretKeyEntry keyEntry = (SecretKeyEntry)ks.getEntry("key", protParam);
		SecretKey key = keyEntry.getSecretKey();
		
		IvParameterSpec iv = new IvParameterSpec(Base64.getDecoder().decode("bLZVytOnvck24n46GTJXrA=="));
		Cipher cipher = Cipher.getInstance("AES/OFB/PKCS5Padding");
		cipher.init(Cipher.DECRYPT_MODE, key, iv);
		byte[] dec = cipher.doFinal(Base64.getDecoder().decode("j+qeGp3rvjH+cAYWhdjJ1jNFBzBuXfVdjb6jWYcZx0WC+RqkpGxx3L5Dje5IECHM"));
		System.out.println(new String(dec));
	}

}
