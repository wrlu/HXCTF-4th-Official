//
//  CheckFlag.h
//  iPhoneNoNeed
//
//  Created by 小路 on 2018/5/16.
//  Copyright © 2018年 小路. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CommonCrypto/CommonDigest.h>
#import "GetValue.h"

@interface CheckFlag : NSObject

+ (instancetype)checkFlagWithFlag:(NSString * _Nullable)flag;
- (BOOL)checkFlag;

@end
