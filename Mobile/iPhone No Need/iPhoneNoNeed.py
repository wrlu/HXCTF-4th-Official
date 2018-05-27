import hashlib
import random

array = []

def base_str():
    return "01" 
    
def radom_str4():
    string = [random.choice(base_str()) for i in range(4)]
    return string[0]+string[1]+string[2]+string[3]

def random_string():
    while True:
        result = radom_str4() + "-" + radom_str4() + "-" + radom_str4() + "-" + radom_str4()
        if result in array:
            continue
        else:
            array.append(result)
            break
    return result

flag="0000-0001-0010-1001"
md5=hashlib.md5()
md5.update(flag.encode("utf-8"))
targetvalue=md5.hexdigest()
print(targetvalue)

inp=random_string()
md5=hashlib.md5()
md5.update(inp.encode("utf-8"))
md5value=md5.hexdigest()

while md5value!=targetvalue:
    inp=random_string()
    md5=hashlib.md5()
    md5.update(inp.encode("utf-8"))
    md5value=md5.hexdigest()

print(inp)
