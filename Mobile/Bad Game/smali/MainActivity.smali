.class public Lcn/xiaolus/testbackservice/MainActivity;
.super Landroid/support/v7/app/e;


# direct methods
.method public constructor <init>()V
    .locals 0

    invoke-direct {p0}, Landroid/support/v7/app/e;-><init>()V

    return-void
.end method


# virtual methods
.method protected onCreate(Landroid/os/Bundle;)V
    .locals 1

    invoke-super {p0, p1}, Landroid/support/v7/app/e;->onCreate(Landroid/os/Bundle;)V

    const p1, 0x7f09001b

    invoke-virtual {p0, p1}, Lcn/xiaolus/testbackservice/MainActivity;->setContentView(I)V

    new-instance p1, Landroid/content/Intent;

    const-class v0, Lcn/xiaolus/testbackservice/BackService;

    invoke-direct {p1, p0, v0}, Landroid/content/Intent;-><init>(Landroid/content/Context;Ljava/lang/Class;)V

    invoke-virtual {p0, p1}, Lcn/xiaolus/testbackservice/MainActivity;->startService(Landroid/content/Intent;)Landroid/content/ComponentName;

    return-void
.end method
