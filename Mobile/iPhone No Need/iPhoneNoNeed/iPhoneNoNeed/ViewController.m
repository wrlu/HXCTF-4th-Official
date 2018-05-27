//
//  ViewController.m
//  iPhoneNoNeed
//
//  Created by 小路 on 2018/5/8.
//  Copyright © 2018年 小路. All rights reserved.
//

#import "ViewController.h"

@interface ViewController ()
@property (weak, nonatomic) IBOutlet UITextField *textFieldInput;

@end

@implementation ViewController

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view, typically from a nib.
}

- (IBAction)didTapScreen:(id)sender {
    [_textFieldInput resignFirstResponder];
}

- (IBAction)didPressOkButton:(UITextField *)sender {
    [_textFieldInput resignFirstResponder];
    if([self check:_textFieldInput.text]==YES) {
        UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"提示" message:[NSString stringWithFormat:@"HXCTF{%@}", _textFieldInput.text] preferredStyle:(UIAlertControllerStyleAlert)];
        UIAlertAction *btnAction = [UIAlertAction actionWithTitle:@"好" style:(UIAlertActionStyleDefault) handler:nil];
        [alert addAction:btnAction];
        [self presentViewController:alert animated:YES completion:nil];
    } else {
        UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"错误" message:@"0ops! Your flag is wrong." preferredStyle:(UIAlertControllerStyleAlert)];
        UIAlertAction *btnAction = [UIAlertAction actionWithTitle:@"好" style:(UIAlertActionStyleDefault) handler:nil];
        [alert addAction:btnAction];
        [self presentViewController:alert animated:YES completion:nil];
    }
}

- (IBAction)didPressCheckButton:(UIButton *)sender {
    [_textFieldInput resignFirstResponder];
    if([self check:_textFieldInput.text]==YES) {
        UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"提示" message:[NSString stringWithFormat:@"HXCTF{%@}", _textFieldInput.text] preferredStyle:(UIAlertControllerStyleAlert)];
        UIAlertAction *btnAction = [UIAlertAction actionWithTitle:@"好" style:(UIAlertActionStyleDefault) handler:nil];
        [alert addAction:btnAction];
        [self presentViewController:alert animated:YES completion:nil];
    } else {
        UIAlertController *alert = [UIAlertController alertControllerWithTitle:@"错误" message:@"0ops! Your flag is wrong." preferredStyle:(UIAlertControllerStyleAlert)];
        UIAlertAction *btnAction = [UIAlertAction actionWithTitle:@"好" style:(UIAlertActionStyleDefault) handler:nil];
        [alert addAction:btnAction];
        [self presentViewController:alert animated:YES completion:nil];
    }
}

- (IBAction)didPressCleanButton:(UIButton *)sender {
    [_textFieldInput resignFirstResponder];
    [_textFieldInput setText:@""];
}

- (BOOL)check:(NSString * _Nullable)Flag {
    CheckFlag *checker = [CheckFlag checkFlagWithFlag:Flag];
    return [checker checkFlag];
}


- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


@end
