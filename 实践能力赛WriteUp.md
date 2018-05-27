# Web

# Reverse

# Mobile
## EasyAndroid
- 本题类型为Android逆向，属于较容易的静态分析题目。
- 首先使用JEB或者dex2jar等工具，获得Java源代码。如果使用dex2jar工具转换为jar的话，程序可能会报错，但是不影响做题。
- Java源代码结构较简单，大致如下图所示：

```
cn.xiaolus.easyandroid
--> BuildConfig.class
--> MainActivity.class
--> R.class
--> SignInActivity.class
--> SignUpActivity.class
```

- 在各个文件中查找“HXCTF”字符串，发现`SignInActivity.class`和`SignUpActivity.class`文件中都存在该字符串：

```java
//SignInActivity.class
private void solveDatabase() {
        final StringBuilder sb = new StringBuilder(Environment.getExternalStorageDirectory().getAbsolutePath());
        sb.append("/HXCTF{welcome_to_use_/");
        final File file = new File(sb.toString());
        if (!Environment.getExternalStorageState().equals("mounted")) {
            System.exit(1);
        }
        if (!file.exists()) {
            file.mkdir();
        }
        final StringBuilder sb2 = new StringBuilder(file.getAbsolutePath());
        sb2.append("the_beautiful_android}.sqlite");
        (this.sqLiteDatabase = SQLiteDatabase.openOrCreateDatabase(sb2.toString(), (SQLiteDatabase$CursorFactory)null)).execSQL("create table if not exists users( username varchar(32) primary key,passwordhash varchar(32),salt varchar(16));");
    }
```

```java
//SignUpActivity.class
private void solveDatabase() {
        final StringBuilder sb = new StringBuilder(Environment.getExternalStorageDirectory().getAbsolutePath());
        sb.append("/HXCTF{welcome_to_use_/");
        final File file = new File(sb.toString());
        if (!Environment.getExternalStorageState().equals("mounted")) {
            System.exit(1);
        }
        if (!file.exists()) {
            file.mkdir();
        }
        final StringBuilder sb2 = new StringBuilder(file.getAbsolutePath());
        sb2.append("the_beautiful_android}.sqlite");
        (this.sqLiteDatabase = SQLiteDatabase.openOrCreateDatabase(sb2.toString(), (SQLiteDatabase$CursorFactory)null)).execSQL("create table if not exists users( username varchar(32) primary key,passwordhash varchar(32),salt varchar(16));");
    }
```

- 两者功能都相同，都是查找了外部存储空间的`/HXCTF{welcome_to_use_/the_beautiful_android}.sqlite`这个SQLite数据库，组合文件夹名称和文件名称可得到本题的flag：

```
HXCTF{welcome_to_use_the_beautiful_android}
```

## iPhone No Need
- 本题类型为iOS逆向，属于较难的静态分析题目。
- 对于iOS的安装文件ipa，不能使用安卓的逆向工具去解决，使用IDA Pro即可。iOS的应用程序主要使用Objective-C和Swift编写，本题为Objective-C。Objective-C和C、C++以及Java这些语言都不同，Objective-C是一门动态的语言。简单来说，在Objective-C中，所谓的方法调用，实际上是通过给对象发送不同的消息完成的。当程序反编译出伪代码时可以发现，大多数方法调用都是通过一个名为`objc_msgsend`的函数完成的，这是这门动态语言的最大特点，所以这就给逆向造成了不适应感。
- 使用IDA Pro 64-bit工具打开题目所给的ipa文件，可以对其进行反汇编和反编译。

## BadGame
- 本题类型为Android逆向，属于较难的静态分析题目。
- 本题题目所给的apk实际上是当下最火热的游戏之一——旅行青蛙的安装包，但是根据题目描述可知，这个游戏安装包已经被植入了“恶意代码”，只是程序运行起来和正常的原版旅行青蛙没有什么不同。显然出题人也没有旅行青蛙的全部源代码，但是仍然有能力向其中注入“恶意代码”，本题模拟的就是商业软件因没有加固而被植入恶意代码的情况。
- 由此可知本题的代码量较一般的逆向题目相比都是大得多的，题目apk本身就有50MB左右，所以如何定位到自己想要的代码才最关键。
- 同样是使用JEB或者dex2jar等工具查看Java源代码


# Crypto

# Misc