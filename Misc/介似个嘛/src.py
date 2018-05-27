import base64
s = 'fun_manchest3r!'
s = base64.b32encode(s)
s = 'HXCTF{' + s + '}'
print s
res = ''
binbin = ''
zo = '01'
for c in s:
    temp = bin(int(ord(c)))[2:]
    temp = '0' * (8-len(temp)) + temp
    for cc in temp:
        if(cc == '0'):
            res += zo
        else:
            if(zo == '01'):
                zo = '10'
            else:
                zo = '01'
            res += zo

s = hex(int(res, 2))[2:].upper()[0:-1]
print s

s = '010' + bin(int(s, 16))[2:]
res = ''
for i in range(1, len(s)/2):
    if s[i*2-1] != s[i*2]:
        res += '0'
    else:
        res += '1'

ss = ''
for i in xrange(len(res)/8):
    ss += chr(int(res[i*8:i*8+8], 2))
print ss
