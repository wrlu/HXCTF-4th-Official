//
//  CheckFlag.m
//  iPhoneNoNeed
//
//  Created by 小路 on 2018/5/16.
//  Copyright © 2018年 小路. All rights reserved.
//

#import "CheckFlag.h"

@interface CheckFlag ()

@property (nonatomic,nullable) NSString *flag;

@end

@implementation CheckFlag

static CheckFlag *instance;

+ (instancetype)checkFlagWithFlag:(NSString *)flag {
    static dispatch_once_t onceToken;
    dispatch_once(&onceToken, ^{
        instance = [[self alloc] initWithFlag:flag];
    });
    return instance;
}

- (instancetype)initWithFlag:(NSString * _Nullable)flag {
    _flag = flag;
    return self;
}
//0000-0001-0010-1001
- (BOOL)checkFlag {
    if (_flag == nil || [_flag isEqualToString: @""]) {
        return NO;
    }
    const char *flagStr = [_flag UTF8String];
    if (flagStr[19] != '\0' || flagStr[4] != '-' || flagStr[9] != '-' || flagStr[14] != '-') {
        return NO;
    }
    for(int i = 0;i < 19;i++) {
        if(i == 4 || i == 9 || i == 14) {
            continue;
        }
        if([CheckFlag isAvaliableCharacter:flagStr[i]]==NO) {
            return NO;
        }
    }
    NSString * hashValue = [CheckFlag getMD5OfMessage:_flag];
    hashValue = [hashValue lowercaseString];
    if([hashValue isEqualToString:[GetValue someBinStringMD5Value]]) {
        return YES;
    } else {
        return NO;
    }
}

+ (BOOL)isAvaliableCharacter:(const char)chr {
    if(chr >= '0' && chr <= '1') {
        return YES;
    } else {
        return NO;
    }
}

+ (NSString *)getMD5OfMessage:(NSString *)message {
    const char *messageStr=[message UTF8String];
    unsigned char result[CC_MD5_DIGEST_LENGTH];
    CC_MD5(messageStr, (CC_LONG)message.length, result);
    NSString *hashValue=@"";
    for(int i=0;i<CC_MD5_DIGEST_LENGTH;++i) {
        hashValue=[NSString stringWithFormat:(@"%@%02x"),hashValue,result[i]];
    }
    return hashValue;
}

@end
