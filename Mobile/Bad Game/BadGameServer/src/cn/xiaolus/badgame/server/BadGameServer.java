package cn.xiaolus.badgame.server;

import java.io.BufferedOutputStream;
import java.io.IOException;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.Scanner;

public class BadGameServer {
	
	private static final String FLAG = "HXCTF{Sm@11_Fr0g_C0nt@1ns_B@d_C0de}";
	
	public static void main(String[] args) throws IOException {
		new BadGameServer().service(1219);
	}
	
	public void service(int port) throws IOException {
		@SuppressWarnings("resource")
		ServerSocket serverSocket = new ServerSocket(port);
		System.out.println("[*] Starting listen port "+port);
		while(true) {
			Socket socket = serverSocket.accept();
			System.out.println("[+] Get connection from:"+socket.getInetAddress().getHostAddress()+":"+socket.getPort());
			try {
				new Thread(new ServerHandler(socket)).start();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		
	}
	
	class ServerHandler implements Runnable {
		
		private Socket socket;
		private Scanner scanner;
		private PrintWriter writer;
		
		public ServerHandler(Socket socket) throws IOException {
			this.socket = socket;
			scanner = new Scanner(socket.getInputStream());
			writer = new PrintWriter(new BufferedOutputStream(socket.getOutputStream()));
		}
		
		@Override
		public void run() {
			String imei = scanner.nextLine();
			System.out.println(imei);
			if(imei.equals("flag")) {
				writer.println("Here is your flag:");
				writer.println(FLAG);
				writer.println("Bye");
				writer.flush();
			}
			scanner.close();
			writer.close();
			try {
				socket.close();
			} catch (Exception e) {
				e.printStackTrace();
			}
			System.out.println("[-] Connection closed");
		}
	}
}
