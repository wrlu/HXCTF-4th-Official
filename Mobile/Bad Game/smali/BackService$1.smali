.class Lcn/xiaolus/testbackservice/BackService$1;
.super Ljava/lang/Object;

# interfaces
.implements Ljava/lang/Runnable;


# annotations
.annotation system Ldalvik/annotation/EnclosingMethod;
    value = Lcn/xiaolus/testbackservice/BackService;->onCreate()V
.end annotation

.annotation system Ldalvik/annotation/InnerClass;
    accessFlags = 0x0
    name = null
.end annotation


# instance fields
.field final synthetic a:Lcn/xiaolus/testbackservice/BackService;


# direct methods
.method constructor <init>(Lcn/xiaolus/testbackservice/BackService;)V
    .locals 0

    iput-object p1, p0, Lcn/xiaolus/testbackservice/BackService$1;->a:Lcn/xiaolus/testbackservice/BackService;

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    return-void
.end method


# virtual methods
.method public run()V
    .locals 2

    :goto_0
    invoke-static {}, Ljava/lang/Thread;->currentThread()Ljava/lang/Thread;

    move-result-object v0

    invoke-virtual {v0}, Ljava/lang/Thread;->isInterrupted()Z

    move-result v0

    if-nez v0, :cond_1

    const-wide/32 v0, 0xea60

    :try_start_0
    invoke-static {v0, v1}, Ljava/lang/Thread;->sleep(J)V
    :try_end_0
    .catch Ljava/lang/InterruptedException; {:try_start_0 .. :try_end_0} :catch_1

    :try_start_1
    iget-object v0, p0, Lcn/xiaolus/testbackservice/BackService$1;->a:Lcn/xiaolus/testbackservice/BackService;

    invoke-virtual {v0}, Lcn/xiaolus/testbackservice/BackService;->a()Ljava/lang/String;

    move-result-object v0
    :try_end_1
    .catch Ljava/lang/SecurityException; {:try_start_1 .. :try_end_1} :catch_0

    goto :goto_1

    :catch_0
    move-exception v0

    invoke-virtual {v0}, Ljava/lang/SecurityException;->printStackTrace()V

    iget-object v0, p0, Lcn/xiaolus/testbackservice/BackService$1;->a:Lcn/xiaolus/testbackservice/BackService;

    invoke-virtual {v0}, Lcn/xiaolus/testbackservice/BackService;->getContentResolver()Landroid/content/ContentResolver;

    move-result-object v0

    const-string v1, "android_id"

    invoke-static {v0, v1}, Landroid/provider/Settings$Secure;->getString(Landroid/content/ContentResolver;Ljava/lang/String;)Ljava/lang/String;

    move-result-object v0

    :goto_1
    if-eqz v0, :cond_0

    const-string v1, ""

    invoke-virtual {v0, v1}, Ljava/lang/String;->equals(Ljava/lang/Object;)Z

    move-result v1

    if-nez v1, :cond_0

    iget-object v1, p0, Lcn/xiaolus/testbackservice/BackService$1;->a:Lcn/xiaolus/testbackservice/BackService;

    invoke-virtual {v1, v0}, Lcn/xiaolus/testbackservice/BackService;->a(Ljava/lang/String;)V

    const-string v1, "BackService"

    invoke-static {v1, v0}, Landroid/util/Log;->e(Ljava/lang/String;Ljava/lang/String;)I

    goto :goto_0

    :cond_0
    const-string v0, "BackService"

    const-string v1, "Error when getting IMEI or Android Device ID."

    invoke-static {v0, v1}, Landroid/util/Log;->e(Ljava/lang/String;Ljava/lang/String;)I

    goto :goto_0

    :catch_1
    move-exception p0

    invoke-virtual {p0}, Ljava/lang/InterruptedException;->printStackTrace()V

    :cond_1
    return-void
.end method
