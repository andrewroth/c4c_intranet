var sProvinceList;					// formatted Province list
var aDistrictList = new Array();	// an array of district lists.
var aCountyList = new Array();		// an array of county lists.

function initDistrictandCountyLists() {
// This function will initialize the District and County lists.

	sProvinceList='-----------------------:0:Anhui:1:Beijing:2:Chongqing:3:Fujian:4:Gansu:5:Guangdong:6:Guangxi:7:Guizhou:8:Hainan:9:Hebei:10:Heilongjiang:11:Henan:12:Hubei:13:Hunan:14:Inner Mongolia:15:Jiangsu:16:Jiangxi:17:Jilin:18:Liaoning:19:Ningxia:20:Qinghai:21:Shaanxi:22:Shandong:23:Shanghai:24:Shanxi:25:Sichuan:26:Tianjin:27:Tibet:28:Xinjiang:29:Yunnan:30:Zhejiang:31:';
	
	aDistrictList[0]='--------------------------:0:';
	aDistrictList[1]='--------------------------:0:Anqing:1:Bengbu:2:Bozhou:3:Chaohu:4:Chuzhou:5:Fuyang:6:Guichi:7:Hefei:8:Huaibei:9:Huainan:10:Huangshan:11:Luan:12:Maanshan:13:Suzhou:14:Tongling:15:Wuhu:16:Xuanzhou:17:';
	aDistrictList[2]='--------------------------:0:Beijing:18:Changping:19:Daxing:20:Huairou:21:Miyun:22:Pinggu:23:';
	aDistrictList[3]='--------------------------:0:Chongqing:24:Qianjiang:25:Wanzhou:26:';
	aDistrictList[4]='--------------------------:0:Fuzhou:27:Longyan:28:Nanping:29:Ningde:30:Putian:31:Quanzhou:32:Sanming:33:Xiamen:34:Zhangzhou:35:';
	aDistrictList[5]='--------------------------:0:Baiyin:36:Dingxi:37:Gannan:38:Jiayuguan:39:Jinchang:40:Jiuquan:41:Lanzhou:42:Linxia:43:Longnan:44:Pingliang:45:Qingyang:46:Tianshui:47:Wuwei:48:Zhangye:49:';
	aDistrictList[6]='--------------------------:0:Chaozhou:50:Dongguan:51:Foshan:52:Guangzhou:53:Heyuan:54:Huizhou:55:Jiangmen:56:Jieyang:57:Maoming:58:Meizhou:59:Qingyuan:60:Shantou:61:Shanwei:62:Shaoguan:63:Shenzhen:64:Yangjiang:65:Yunfu:66:Zhangjiang:67:Zhaoqing:68:Zhongshan:69:Zhuhai:70:';
	aDistrictList[7]='--------------------------:0:Beihai:71:Bose:72:Fangchenggang:73:Guigang:74:Guilin:75:Hechi:76:Hezhou:77:Liuzhou:78:Nanning:79:Qinzhou:80:Wuzhou:81:Yulin:82:';
	aDistrictList[8]='--------------------------:0:Anshan:83:Bijie:84:Guiyang:85:Liupanshui:86:Qianxinan:87:Quandongnan:88:Quannan:89:Tongren:90:Zunyi:91:';
	aDistrictList[9]='--------------------------:0:Haikou:92:Sanya:93:Xianji:94:';
	aDistrictList[10]='--------------------------:0:Baoding:95:Cangzhou:96:Chengde:97:Handan:98:Hengshui:99:Langfang:100:Qinhuangdao:101:Shijiazhuan:102:Tangshan:103:Xingtai:104:Zhangjiakou:105:';
	aDistrictList[11]='--------------------------:0:Daqing:106:Daxingan:107:Harbin:108:Heihe:109:Jiamusi:110:Jixi:111:Mudanjiang:112:Qiqihar:113:Qitaihe:114:Shuangyashan:115:Suihua:116:Xiangfan:117:Yichun:118:';
	aDistrictList[12]='--------------------------:0:Anyang:119:Hebi:120:Jiaozuo:121:Jiyuan:122:Kaifeng:123:Louyang:124:Luohe:125:Nanyang:126:Pingdingshan:127:Puyang:128:Sanmenxia:129:Shangqiu:130:Xinxiang:131:Xinyang:132:Xuchang:133:Zhengzhou:134:Zhoikou:135:Zhumadian:136:';
	aDistrictList[13]='--------------------------:0:Enshi:137:Ezhou:138:Huanggang:139:Huangshi:140:Jingmen:141:Jingzhou:142:Shiyan:143:Suizhou:144:Wuhan:145:Xiangfan:146:Xianning:147:Xiaogan:148:Yichang:149:';
	aDistrictList[14]='--------------------------:0:Changde:150:Changsha:151:Chenzhou:152:Hengyang:153:Huaihua:154:Loudi:155:Shaoyang:156:Xiangtan:157:Xiangxi:158:Yiyang:159:Yongzhou:160:Yueyang:161:Zhangjiajie:162:Zhuzhou:163:';
	aDistrictList[15]='--------------------------:0:Alxa Meng:164:Baotou:165:Bayannur:166:Chifeng:167:Hinggan Meng:168:Hohhot:169:Hulun Buir:170:Ih Ju Meng:171:Tongliao:172:Wuhai:173:Xilin Gol:174:';
	aDistrictList[16]='--------------------------:0:Changzhou:175:Huaiyin:176:Lianyungang:177:Nanjing:178:Nantong:179:Suqian:180:Suzhou:181:Taizhou:182:Wuxi:183:Xuzhou:184:Yancheng:185:Yangzhou:186:Zhenjiang:187:';
	aDistrictList[17]='--------------------------:0:Fuzhou:188:Ganzhou:189:Jian:190:Jingdezhen:191:Jiujiang:192:Nanchang:193:Pingxiang:194:Shangrao:195:Xinyu:196:Yichun:197:Yingtan:198:';
	aDistrictList[18]='--------------------------:0:Baicheng:199:Baishan:200:Changchun:201:Jilin:202:Liaoyuan:203:Siping:204:Songyuan:205:Tonghua:206:Yanbian:207:';
	aDistrictList[19]='--------------------------:0:Anshan:208:Benxi:209:Chaoyang:210:Dalian:211:Dandong:212:Fushan:213:Fuxin:214:Huludao:215:Jinzhou:216:Liaoyang:217:Panjin:218:Shenyang:219:Teiling:220:Yingkou:221:';
	aDistrictList[20]='--------------------------:0:Guyang:222:Shizuishan:223:Wuzhong:224:Yinchuan:225:';
	aDistrictList[21]='--------------------------:0:Golog:226:Haibei:227:Haidong:228:Hainan:229:Haixi:230:Huangnan:231:Xining:232:Yushu:233:';
	aDistrictList[22]='--------------------------:0:Ankang:234:Baoji:235:Hanzhong:236:Shangluo:237:Tongchuan:238:Weinan:239:Xian:240:Xianyang:241:Yanan:242:Yulin:243:';
	aDistrictList[23]='--------------------------:0:Binzhou:244:Dezhou:245:Dongying:246:Heze:247:Jinan:248:Jining:249:Laiwu:250:Liaocheng:251:Linyi:252:Qingdao:253:Rizhao:254:Taian:255:Weifang:256:Weihai:257:Yantai:258:Zaozhuang:259:Zibo:260:';
	aDistrictList[24]='--------------------------:0:Chongming:261:Fengxian:262:Nanhui:263:Qingpu:264:Shanghai:265:';
	aDistrictList[25]='--------------------------:0:Changzhi:266:Datong:267:Jincheng:268:Jinzhong:269:Linfen:270:Luliang:271:Shuozhou:272:Taiyuan:273:Xinzhou:274:Yangquan:275:Yuncheng:276:';
	aDistrictList[26]='--------------------------:0:Aba:277:Bazhong:278:Chengdu:279:Dachuan:280:Deyang:281:Ganzi:282:Guangan:283:Guangyuan:284:Leshan:285:Liangshan:286:Luzhou:287:Meishan:288:Mianyang:289:Nanchong:290:Neijiang:291:Panzhihua:292:Suining:293:Ya\'an:294:Yibin:295:Zigong:296:Ziyang:297:';
	aDistrictList[27]='--------------------------:0:Baodi:298:Jinghai:299:Jixian:300:Ninghe:301:Tianjin:302:Wuqing:303:';
	aDistrictList[28]='--------------------------:0:Lhasa:304:Nagqu:305:Ngari:306:Nyingchi:307:Qamdo:308:Shannan:309:Xigaze:310:';
	aDistrictList[29]='--------------------------:0:Aksu:311:Altay:312:Bayingolin:313:Bortala:314:Changji:315:Hami:316:Hotan:317:Karamay Shi:318:Kashi:319:Kizilsu:320:Kuytun:321:Lli Kazar:322:Shihezi:323:Tacheng:324:Turpan:325:Urumqi:326:';
	aDistrictList[30]='--------------------------:0:Baoshan:327:Chuxiong:328:Dali:329:Dehong:330:Diqing:331:Honghe:332:Kunming:333:Lijiang:334:Lincang:335:Nujiang:336:Qujing:337:Simao:338:Wenshan:339:Xishuangbana:340:Yuxi:341:Zhaotong:342:';
	aDistrictList[31]='--------------------------:0:Hangzhou:343:Huzhou:344:Jiaxing:345:Jinhua:346:Lishui:347:Ningbo:348:Shaoxing:349:Taizhou:350:Wenzhou:351:Zhoushan:352:';
	
	aCountyList[0]='---------------------------------:0:';
	aCountyList[1]='---------------------------------:0:Anqing Shi:199:Huaining Xian:204:Qianshan:207:Susong Xian:201:Taihu:203:Tongcheng Xian:200:Wangjiang:206:Yuexi:205:Zongyang:202:';
	aCountyList[2]='---------------------------------:0:Bengbu Shi:251:Guzhen:253:Huaiyuan:252:Wuhe:254:';
	aCountyList[3]='---------------------------------:0:Bozhou Shi:261:';
	aCountyList[4]='---------------------------------:0:Chaohu Shi:219:Hanshan Xian:220:Hexian:223:Lujiang Xian:222:Wuwei Xian:221:';
	aCountyList[5]='---------------------------------:0:Chuzhou Shi:192:Dingyuan:197:Fengyang:198:Laian Xian:196:Mingguang:194:Quanjiao:195:Tianchang:193:';
	aCountyList[6]='---------------------------------:0:Funan Xian:213:Fuyang:208:Guoyang:212:Jieshou:209:Linquan:211:Lixin:210:Mengcheng:216:Taihe Xian:214:Yingshang:215:';
	aCountyList[7]='---------------------------------:0:Dongzhi:263:Guichi:262:Qingyang:265:Shitai:264:';
	aCountyList[8]='---------------------------------:0:Changfeng:187:Feidong Xian:188:Feixi Xian:189:Hefei Shi:186:';
	aCountyList[9]='---------------------------------:0:Huaibei Shi:217:Suixi Xian:218:';
	aCountyList[10]='---------------------------------:0:Fengtai:191:Huainan Shi:190:';
	aCountyList[11]='---------------------------------:0:Huangshan Shi:240:Qimen:243:Shexian:242:Xiuning:241:Yixian:244:';
	aCountyList[12]='---------------------------------:0:Huoqiu:235:Huoshan Xian:234:Jinzhai:237:Luan:232:Shouxian:233:Shucheng:236:';
	aCountyList[13]='---------------------------------:0:Dangtu:260:Maanshan Shi:259:';
	aCountyList[14]='---------------------------------:0:Dangshan Xian:249:Lingbi:250:Sixian:248:Suxian:245:Suzhou Shi:246:Xiaoxian:247:';
	aCountyList[15]='---------------------------------:0:Tongling Shi:239:Tongling Xian:238:';
	aCountyList[16]='---------------------------------:0:Fanchang:258:Nanling:257:Wuhu Shi:256:Wuhu Xian:255:';
	aCountyList[17]='---------------------------------:0:Guangdu:227:Jingde:230:Jingxian:229:Jixi:231:Langxi Xian:228:Ningguo:226:Xuancheng:224:Xuanzhou Shi:225:';
	aCountyList[18]='---------------------------------:0:Beijing Shi:1955:Chaoyang:1959:Chongwen:1965:Dongcheng:1954:Fangshan:1961:Fengshan:1962:Fengtai:1963:Mentougou Qu:1964:Shijingshan:1957:Shunyi:1958:Xicheng:1956:Yanqing:1960:';
	aCountyList[19]='---------------------------------:0:Changping:1968:';
	aCountyList[20]='---------------------------------:0:Daxing:1966:';
	aCountyList[21]='---------------------------------:0:Huairou:1969:';
	aCountyList[22]='---------------------------------:0:Miyun:1970:';
	aCountyList[23]='---------------------------------:0:Pinggu:1967:';
	aCountyList[24]='---------------------------------:0:Banan:706:Beibei:699:Bishan:718:Changshou Xian:714:Chengkou:722:Chongqing Xian:696:Dadukou:702:Dazu:719:Dianjiang:723:Fengdu:725:Fuling Shi:707:Hechuan Xian:711:Jiangbei Xian:705:Jiangjin Xian:712:Jiulongpo:703:Liangping Xian:721:Nanchuan:713:Qijiang:715:Rongchang:717:Shapingba:698:Shuangqiao:700:Shuangqiao:701:Tongliang:720:Tongnan:716:Wansheng:704:Wanzhou:709:Wulong:724:Yongchuan Xian:710:Yubei:708:Yuzhong:697:';
	aCountyList[25]='---------------------------------:0:Pengshui:737:Qianjiang:736:Shizhu:733:Xiushan:734:Xiyang:735:';
	aCountyList[26]='---------------------------------:0:Fengjie Xian:727:Kaixian:728:Wanzhou:726:Wushan Xian:732:Wuxi:731:Yunyang:729:Zhongxian:730:';
	aCountyList[27]='---------------------------------:0:Changle:1276:Fuqing Shi:1275:Fuzhou Shi:1274:Lianjiang:1278:Luoyuan:1282:Minhou:1277:Minqing Xian:1281:Pingtan:1279:Yongtai:1280:';
	aCountyList[28]='---------------------------------:0:Changding:1327:Liancheng:1331:Longyan:1325:Shanghang:1329:Wuping:1328:Yongding:1330:Zhangping Shi:1326:';
	aCountyList[29]='---------------------------------:0:Guangze:1321:Jian\'ou:1316:Jianyang:1319:Nanping:1315:Pucheng Xian:1323:Shaowu:1317:Shunchang:1322:Songxi:1320:Yishan Xian:1318:Zhenghe:1324:';
	aCountyList[30]='---------------------------------:0:Fu\'an:1333:Fuding:1334:Guitian:1339:Ningde:1332:Pingnan:1338:Shouning Xian:1335:Xiapu:1336:Zherong:1337:Zhouning:1340:';
	aCountyList[31]='---------------------------------:0:Putian Shi:1295:Xianyou Xian:1296:';
	aCountyList[32]='---------------------------------:0:Anxi Xian:1303:Dehua Xian:1304:Hui\'an Xian:1301:Jinjiang Xian:1299:Nan\'an Xiabn:1300:Quanzhou Shi:1297:Shishi:1298:Yongchun:1302:';
	aCountyList[33]='---------------------------------:0:Datian:1288:Jiangle:1287:Jianning:1290:Longxi:1292:Mingxi Xian:1286:Ninghua:1289:Qingliu:1293:Sanming:1284:Shaxian:1291:Taining:1294:Yongan:1285:';
	aCountyList[34]='---------------------------------:0:Xiamen:1283:';
	aCountyList[35]='---------------------------------:0:Changtai:1313:Dongshan Xian:1312:Hua\'an Xian:1311:Longhaai:1306:Nanjing Shi:1308:Pinghe:1307:Yunxiao Xian:1314:Zhangpu:1310:Zhangzhou:1305:Zhao\'an:1309:';
	aCountyList[36]='---------------------------------:0:Baiyin Shi Ping:2268:Huining Xian:2271:Jingtai:2270:Jingyuan:2269:';
	aCountyList[37]='---------------------------------:0:Dingxi Xian:2218:Lintao:2224:Longxi:2221:Minxian:2219:Tongwei:2222:Weiyuan Xian:2220:Zhangxian:2223:';
	aCountyList[38]='---------------------------------:0:Dnaqu:2244:Gannan:2240:Hezuo:2241:Lintan:2242:Luqu:2246:Maqu:2245:Xiahe:2247:Zhuoni:2243:';
	aCountyList[39]='---------------------------------:0:Jiayuguan:2278:';
	aCountyList[40]='---------------------------------:0:Jinchang:2266:Yongchang:2267:';
	aCountyList[41]='---------------------------------:0:Akesai:2295:Anxi:2293:Dunhuang:2292:Jinta:2294:Jiuquan:2289:Jiuquan:2291:Subei:2296:Yumen:2290:';
	aCountyList[42]='---------------------------------:0:Gaolan:2217:Lanzhou Shi:2214:Yongdeng:2215:Yuzhong:2216:';
	aCountyList[43]='---------------------------------:0:Dongxiang:2264:Guanghe:2262:Hezheng:2263:Jishishan:2265:Kangle Xian:2260:Linxia:2258:Linxia Hui:2259:Yongjing:2261:';
	aCountyList[44]='---------------------------------:0:Chengxian:2249:Danchang:2256:Huixian:2255:Kangxian:2251:Liangdang:2254:Lixian:2250:Longnan:2248:Wenxian:2253:Wudu:2252:Xihe Xian:2257:';
	aCountyList[45]='---------------------------------:0:Chongxin:2228:Huating:2229:Jingchuan:2230:Jingning:2227:Ligngtai:2226:Pingliang Shi:2225:Zhuanglang Xian:2231:';
	aCountyList[46]='---------------------------------:0:Heshui:2235:Huachi:2236:Huanxian:2237:Ningxian:2238:Qingyang:2233:Xifeng:2232:Zhengning Xian:2239:Zhenyuan:2234:';
	aCountyList[47]='---------------------------------:0:Gangu:2274:Qingshui:2275:Taian:2276:Tianshui Shi:2272:Wushan:2273:Zhangjiachuan:2277:';
	aCountyList[48]='---------------------------------:0:Gulang:2281:Minqin:2280:Tianzhu:2282:Wuwei:2279:';
	aCountyList[49]='---------------------------------:0:Gaotai:2287:Inle:2284:Linze:2286:Shanzhou:2285:Sunan:2288:Zhangye:2283:';
	aCountyList[50]='---------------------------------:0:Chao\'an:1237:Chaozhou:1239:Raoping:1238:';
	aCountyList[51]='---------------------------------:0:Dongguan Shi:1250:';
	aCountyList[52]='---------------------------------:0:Foshan Shi:1252:Gaoming:1256:Nanhai Xian:1254:Sanshui Xian:1255:Shunde:1253:';
	aCountyList[53]='---------------------------------:0:Conghua:1178:Guangzhou Shi:1175:Huadu:1176:Panyu:1177:Zengcheng:1179:';
	aCountyList[54]='---------------------------------:0:Dongyuan:1201:Heping:1197:Heyuan:1196:Lianping Xian:1200:Longchuan:1198:Zijin:1199:';
	aCountyList[55]='---------------------------------:0:Boluo Xian:1244:Huidong Xian:1243:Huiyang:1242:Huizhou Shi:1241:Longmen:1245:';
	aCountyList[56]='---------------------------------:0:Enping:1215:Heshan:1214:Jiangmen:1210:Kaiping Xian:1213:Taishan Xian:1211:Xinhui:1212:';
	aCountyList[57]='---------------------------------:0:Huilai Xian:1273:Jiedong:1271:Jiexi Xian:1272:Jieyang Xian:1269:Puning:1270:';
	aCountyList[58]='---------------------------------:0:Dianbai Xian:1265:Gaozhou:1262:Huazhou:1263:Maoming:1261:Xinyi Xian:1264:';
	aCountyList[59]='---------------------------------:0:Daqu:1206:Fengshun:1207:Jiaoling:1205:Meixian:1204:Meizhou:1202:Pingyuan:1209:Wuhua Xian:1208:Xingning Xian:1203:';
	aCountyList[60]='---------------------------------:0:Fogang:1232:Liannan:1236:Lianshan:1235:Lianzhou:1231:Qingxin:1234:Qingyuan:1229:Yangshan:1233:Yingde:1230:';
	aCountyList[61]='---------------------------------:0:Chaoyang Xian:1184:Chenghai:1183:Nan\'ao:1185:Shantou Shi:1182:';
	aCountyList[62]='---------------------------------:0:Haifeng:1248:Lufeng:1247:Luihe:1249:Shanwei:1246:';
	aCountyList[63]='---------------------------------:0:Lechang Xian:1188:Nanxiong:1189:Qujiang Xian:1193:Renhua:1190:Ruyuan:1195:Shaoguan:1186:Shaoguan Shi:1187:Shixing:1191:Wengyuan:1192:Xindu:1194:';
	aCountyList[64]='---------------------------------:0:Shenzhen:1240:';
	aCountyList[65]='---------------------------------:0:Yangchun:1258:Yangdong:1260:Yangjiang:1257:Yangxi Xian:1259:';
	aCountyList[66]='---------------------------------:0:Luoding Xian:1267:Yunan Xian:1268:Yunfu:1266:';
	aCountyList[67]='---------------------------------:0:Leizhou:1218:Lianjiang:1217:Suixi:1220:Wuchuan:1219:Xuwen:1221:Zhangjiang:1216:';
	aCountyList[68]='---------------------------------:0:Deqing:1226:Fengkai:1227:Gaoyao Xian:1223:Guangning:1225:Huaiji Xian:1228:Sihui:1224:Zhaoqing:1222:';
	aCountyList[69]='---------------------------------:0:Zhongshan:1251:';
	aCountyList[70]='---------------------------------:0:Toumen:1181:Zhuhai Shi:1180:';
	aCountyList[71]='---------------------------------:0:Beihai:1053:Hepu:1054:';
	aCountyList[72]='---------------------------------:0:Bose Shi:1022:Debao Xian:1027:Jingxi:1031:Leye:1026:Lingyun:1023:Longlin:1033:Napo:1032:Pingguo:1024:Tiandong:1030:Tianlin:1028:Tianyang:1029:Xilin:1025:';
	aCountyList[73]='---------------------------------:0:Dongxing:1056:Fangchenggang:1055:Shangsi Xian:1057:';
	aCountyList[74]='---------------------------------:0:Guigang Shi:1061:Guiping Xian:1062:Pingnan:1063:';
	aCountyList[75]='---------------------------------:0:Gongcheng:990:Guanyang:985:Guilin Shi:978:Lingchuan:981:Lingui:980:Lipu:986:Longxi:989:Pingle:983:Quanzhou Xian:982:Xingan:984:Yangshou:979:Yongfu:988:Ziyuan:987:';
	aCountyList[76]='---------------------------------:0:Bama:1041:Dahua:1042:Donglan Xian:1039:Du\'an:1040:Fengshan:1037:Hechi:1034:Huanjiang:1044:Luocheng:1043:Nandan:1038:Tian\'e:1036:Xuanzhou:1035:';
	aCountyList[77]='---------------------------------:0:Fuchuan:1067:Hezhou:1064:Zhaoping:1066:Zhongshan:1065:';
	aCountyList[78]='---------------------------------:0:Heshan:1012:Jinxiu:1020:Laibin:1015:Liucheng:1047:Liujiang:1046:Liuzhou:1010:Liuzhou:1045:Liuzhou Shi:1011:Luzhai Xian:1016:Rongan:1013:Rongshui:1019:Sanjiang:1021:Wuxuan Xian:1017:Xiangzhou:1014:Xincheng Xian:1018:';
	aCountyList[79]='---------------------------------:0:Binyang Xian:1005:Chongzuo:1003:Daxin:1001:Fusui:1000:Hengxian:1008:Longan:1007:Longzhou:1009:Mashan Xian:999:Nanning:997:Nanning Shi:975:Ningming:1006:Pingxiang:998:Shanglin:1002:Tiandeng:1004:Wuming:977:Yongjiang:976:';
	aCountyList[80]='---------------------------------:0:Lingshan:1059:Pubei:1060:Qinzhou Shi:1058:';
	aCountyList[81]='---------------------------------:0:Cangwu Xian:1050:Cenxi:1049:Mengshan Xian:1052:Tengxian:1051:Wuzhou:1048:';
	aCountyList[82]='---------------------------------:0:Beiliu Xian:992:Bobai Xian:995:Luchuan Xian:994:Rongxian:993:Xingye:996:Yulin:991:';
	aCountyList[83]='---------------------------------:0:Anshan Shi:677:Guanling:682:Pingba:679:Puding:678:Zhenning:680:Ziyun:681:';
	aCountyList[84]='---------------------------------:0:Bijie:618:Dafang:620:Hezhang Xian:623:Jinsha Xian:622:Nayong:624:Qianxi:619:Weining:625:Zhijin:621:';
	aCountyList[85]='---------------------------------:0:Guiyang Shi:613:Kaiyuan:615:Qingzhen:614:Xifeng:617:Xiuwen:616:';
	aCountyList[86]='---------------------------------:0:Liupanshui:661:Liuzhi:664:Panxian:663:Yongcheng:662:';
	aCountyList[87]='---------------------------------:0:Anlong:644:Ceheng:641:Jinglong:642:Pu\'an:640:Qianxinan:636:Wangmo:638:Xingren:639:Xingyi:637:Zhenfeng Xian:643:';
	aCountyList[88]='---------------------------------:0:Cengong Xian:659:Congjiang:647:Danzhai:660:Huangping:653:Jianhe:655:Jinping:648:Leishan:657:Liping:658:Majiang:650:Quandongnan:645:Rongjiang:654:Sansui:656:Shibing:646:Taijiang:651:Tianzhu Xian:652:Zhenyuan:649:';
	aCountyList[89]='---------------------------------:0:Changshun:693:Dushan:694:Duyun Shi:684:Fuquan:685:Guiding:686:Huishui Xian:687:Libo:690:Longli:691:Loudian:688:Pingtang:692:Quannan:683:Sandu:695:Wengan Xian:689:';
	aCountyList[90]='---------------------------------:0:Dejiang:627:Jiangkou:628:Shiqian:630:Sinan:629:Songtao:633:Tongren:626:Wanshan:631:Yanhe:635:Yinjiang:634:Yuping:632:';
	aCountyList[91]='---------------------------------:0:Chishui:665:Daozhen:675:Fenggang:671:Meitan:674:Renhuai:666:Suiyang:668:Tongzi Xian:669:Wuchuan:676:Xishui Xian:670:Yuqing:673:Zhengan Xian:672:Zunyi Xian:667:';
	aCountyList[92]='---------------------------------:0:Haikou Shi:1165:';
	aCountyList[93]='---------------------------------:0:Sanya Shi:1166:';
	aCountyList[94]='---------------------------------:0:Danzhou:1174:Dongfang:1173:Qionghai Xian:1169:Qiongshan:1170:Tongshi:1168:Wanning:1172:Wenchang:1171:Xianji:1167:';
	aCountyList[95]='---------------------------------:0:Anguo:1862:Anxin:1875:Baoding Shi:1859:Boye Xian:1880:Dingxing:1869:Dingzhou Shi:1861:Fuping:1867:Gaobeidian:1863:Gaoyang:1871:Laisui:1866:Laiyuan:1873:Lixian:1878:Mancheng Xian:1864:Qingyuan Manzu:1865:Quyang:1877:Rongcheng Xian:1872:Shunping:1879:Tangxian:1870:Wangdu:1874:Xiongxian:1881:Xushui Xian:1868:Yixian:1876:Zhuozhou:1860:';
	aCountyList[96]='---------------------------------:0:Botou Shi:1920:Cangxian:1924:Cangzhou Shi:1919:Dongguang:1927:Haixing:1928:Hejian:1923:Huanghua Shi:1922:Mengcun:1933:Nanpi:1931:Qingxian:1925:Renqiu Shi:1921:Wuqiao:1932:Xianxian:1926:Xiaoning:1930:Yanshan:1929:';
	aCountyList[97]='---------------------------------:0:Chengde:1895:Chengde Cheng:1896:Fengning:1901:Kuancheng:1903:Longhua:1898:Luanping:1900:Pingquan Xian:1899:Weichang:1902:Xinlong:1897:';
	aCountyList[98]='---------------------------------:0:Chengan:1832:Cixian:1840:Daming Xian:1833:Feixiang:1838:Guangping:1837:Guantao:1830:Handan Shi:1825:Handan Xian:1827:Jize:1835:Linzhang Xian:1839:Qiuxian:1836:Quzhou:1829:Sheshi:1834:Weixian:1831:Wuan:1826:Yongnian:1828:';
	aCountyList[99]='---------------------------------:0:Anping:1949:Gucheng:1948:Hengshui Shi:1943:Jingxian:1950:Jingxian:1952:Jizhou:1944:Raoyang:1946:Shenzhou:1945:Wuqiang:1953:Wuyi Xian:1951:Zaoqiang:1947:';
	aCountyList[100]='---------------------------------:0:Bazhou Xian:1935:Dacheng:1940:Daguang:1942:Guan:1937:Langfang Shi:1934:Sanhe:1936:Wenan:1941:Xianhe:1939:Yongqing:1938:';
	aCountyList[101]='---------------------------------:0:Changli:1915:Funing Xian:1917:Lulong:1916:Qinglong:1918:Qinhuangdao Shi:1914:';
	aCountyList[102]='---------------------------------:0:Gaocheng Shi:1810:Gaoyi:1819:Jincheng:1811:Jingxing:1814:Luancheng:1815:Luquan:1812:Pingshan:1813:Shenze:1822:Shijiazhuan:1807:Xingtang:1817:Xingtang Xian:1823:Xinji Xian:1808:Xinle:1809:Xunshou:1818:Yuanshi Xian:1824:Zanhuang:1821:Zhaoxian:1820:Zhengding Xian:1816:';
	aCountyList[103]='---------------------------------:0:Fengnan:1906:Fengrun Xian:1910:Luannan Xian:1909:Luanxian:1913:Qianan:1907:Qianxi:1908:Tanghai Xian:1912:Tangshan Shi:1904:Yutian:1911:Zunhua:1905:';
	aCountyList[104]='---------------------------------:0:Baixiang:1845:Guangzong:1852:Julu:1856:Lincheng:1851:Linxi:1853:Longyao:1850:Nangong Shi:1841:Nanhe:1858:Neiqiu Xian:1854:Ningjin:1848:Pingxiang:1855:Qinghe:1847:Renxian:1846:Shahe:1842:Weixian:1849:Xingtai Shi:1843:Xingtai Xian:1844:Xinhe:1857:';
	aCountyList[105]='---------------------------------:0:Chicheng:1887:Chongli:1890:Guyuan:1888:Huailai:1889:Huolu:1893:Kangbao:1884:Shangyi:1891:Wanquan:1894:Xuanhua:1883:Yangyuan:1886:Yuxian:1892:Zhangbei:1885:Zhangjiakou Shi:1882:';
	aCountyList[106]='---------------------------------:0:Daqing:1467:Lindian:1468:Taikang:1471:Zhaoyuan:1470:Zhaozhou:1469:';
	aCountyList[107]='---------------------------------:0:Daxingan:1477:Huma:1478:Mohe:1480:Tahe:1479:';
	aCountyList[108]='---------------------------------:0:Acheng:1403:Bayan:1413:Binxian:1409:Fangzheng:1412:Harbin:1401:Harbin Shi:1402:Hulan:1407:Mulan:1411:Shangzhi:1404:Shuangcheng:1405:Tonghe:1410:Wuchang Xian:1406:Yanshou:1414:Yilan:1408:';
	aCountyList[109]='---------------------------------:0:Bei\'an:1450:Heihe:1449:Nenjiang:1453:Sunwu:1454:Wudalianchi:1451:Xunke:1452:';
	aCountyList[110]='---------------------------------:0:Fujin:1444:Fuyuan:1446:Huanan:1447:Huanchuan:1445:Jiamusi:1442:Tangyuan:1448:Tongjiang:1443:';
	aCountyList[111]='---------------------------------:0:Hulin:1464:Jixi Shi:1462:Mishan:1463:Yadong:1465:';
	aCountyList[112]='---------------------------------:0:Dongning:1431:Hailin:1428:Linkou:1430:Mudanjiang Shi:1425:Muling:1429:Ningan:1427:Suifenghe:1426:';
	aCountyList[113]='---------------------------------:0:Baiquan:1420:Fuyu:1417:Gannan:1423:Kedong:1419:Keshan:1421:Longjiang:1422:Nehe:1416:Qiqihar Shi:1415:Tailai:1424:Yi\'an:1418:';
	aCountyList[114]='---------------------------------:0:Boli:1466:';
	aCountyList[115]='---------------------------------:0:Baoqing:1474:Jixian:1473:Raohe:1476:Shuangyashan Shi:1472:Youyi:1475:';
	aCountyList[116]='---------------------------------:0:Anda:1433:Hailun:1435:Lanxi Shi:1437:Mingshui:1438:Qingan:1440:Qinggang:1439:Suihua:1432:Suileng:1436:Wangkui:1441:Zhaodong:1434:';
	aCountyList[117]='---------------------------------:0:Luobei:1460:Suibin:1461:Xiangfan Shi:1459:';
	aCountyList[118]='---------------------------------:0:Jiayin:1458:Tieli:1457:Yichun:1455:Yichun Shi:1456:';
	aCountyList[119]='---------------------------------:0:Anyang Shi:379:Anyang Xian:381:Huaxian:382:Linzhou:380:Neihuang:383:Tangyin:384:';
	aCountyList[120]='---------------------------------:0:Hebi Shi:347:Qixian:349:Xunxian:348:';
	aCountyList[121]='---------------------------------:0:Bo\'ai:356:Jiaozuo Shi:350:Mengzhou:352:Qinyang:351:Wenxian:354:Wuzhi:355:Xiuwu:353:';
	aCountyList[122]='---------------------------------:0:Jiyuan Shi:372:';
	aCountyList[123]='---------------------------------:0:Kaifeng Shi:274:Kaifeng Xian:273:Lankao:276:Qixia Xian:277:Tongxu:278:Weishi:275:';
	aCountyList[124]='---------------------------------:0:Louning Xian:285:Louyang Shi:279:Luanchuan:288:Mengjin:283:Ruyang:284:Songxian:286:Xinan:287:Yanshi Xian:280:Yichuan Xian:281:Yiyang Xian:282:';
	aCountyList[125]='---------------------------------:0:Linying:364:Luohe:362:Wuyang:365:Yancheng:363:';
	aCountyList[126]='---------------------------------:0:Dengzhou Shi:290:Fangcheng:292:Nanyang Shi:289:Nanzhou:296:Neixiang:297:Sheqi:299:Tanghe:295:Tongbai:291:Xichuan:293:Xinye Xian:298:Xixia:300:Zhenping Xian:294:';
	aCountyList[127]='---------------------------------:0:Baofeng:388:Jiaxian:390:Lushan Xian:391:Pingdingshan:385:Ruzhou Shi:386:Wugang Xian:387:Yexian:389:';
	aCountyList[128]='---------------------------------:0:Fanxian:361:Nanle:358:Puyang Shi:357:Qingfeng:360:Taiquan:359:';
	aCountyList[129]='---------------------------------:0:Lingbao:368:Lushi:370:Mianchi:369:Sanmenxia Shi:366:Xiaxian:371:Yima:367:';
	aCountyList[130]='---------------------------------:0:Minquan Xian:305:Ningling:303:Shangqiu:301:Suixian:308:Xiayi:306:Yongcheng:302:Yucheng:304:Zhecheng:307:';
	aCountyList[131]='---------------------------------:0:Changyuan:315:Fengqiu:316:Huixian Shi:312:Huojia:313:Jiyuan:318:Weihui:311:Xinxiang Shi:309:Xinxiang Xian:310:Yanlin Xian:317:Yuanyang Xian:314:';
	aCountyList[132]='---------------------------------:0:Guangshan:326:Gushi:324:Huaibin:320:Luoshan:325:Shangcheng:323:Xinxian:322:Xinyang Shi:319:Xixian:321:';
	aCountyList[133]='---------------------------------:0:Changge Xian:374:Xiangcheng:378:Xuchang Shi:375:Xuchang Xian:376:Yanling:377:Yuzhou Shi:373:';
	aCountyList[134]='---------------------------------:0:Dengfeng:270:Gongyi:267:Xingyang Xian:271:Xinmi:269:Xinzheng:268:Zhengzhou Shi:266:Zhongmou:272:';
	aCountyList[135]='---------------------------------:0:Dancheng:336:Fugou:334:Huaiyang Xian:330:Luyi Xian:332:Shangshui Xian:329:Shenqiu:335:Taikang Xian:331:Xiangcheng Xian:328:Xihua Xian:333:Zhoikou Shi:327:';
	aCountyList[136]='---------------------------------:0:Biyang Xian:342:Pingyu:343:Queshan:338:Runan Xian:344:Shangcai Xian:340:Suiping:345:Xincai Xian:339:Xiping:341:Zhengyang Xian:346:Zhumadian:337:';
	aCountyList[137]='---------------------------------:0:Badong:182:Dongfeng:181:Enshi Shi:178:Hefeng Xian:183:Jianshi:180:Lichuan:179:Xianfeng:185:Xuanen:184:';
	aCountyList[138]='---------------------------------:0:Ezhou:159:';
	aCountyList[139]='---------------------------------:0:Hongan:128:Huanggang:125:Huangmei Xian:132:Loutian:129:Macheng Shi:126:Qichun Xian:131:Tuanfeng:134:Wuxue Shi:127:Xishui Xian:130:Yingshan Xian:133:';
	aCountyList[140]='---------------------------------:0:Daye:161:Huangshi Shi:160:Yangxin:162:';
	aCountyList[141]='---------------------------------:0:Jingmen Shi:163:Jingshan Xian:165:Shayang:166:Zhongxiang Xian:164:';
	aCountyList[142]='---------------------------------:0:Gongan Xian:139:Honghu:136:Jiangling:141:Jianli Xian:140:Jingzhou:135:Shishou Shi:137:Songzi:138:';
	aCountyList[143]='---------------------------------:0:Danjiangkou:110:Fangxian:115:Shiyan:109:Yunxian:111:Yunxixian:112:Zhushan:113:Zhuxi:114:';
	aCountyList[144]='---------------------------------:0:Qianjiang Shi:175:Shennongjia:177:Suizhou:173:Tianmen Shi:176:Xiantao Shi:174:';
	aCountyList[145]='---------------------------------:0:Hankou:104:Hanyang Xian:105:Huangpi Xian:107:Jianghan:103:Wuchang:106:Wuhan:102:Xinzhou:108:';
	aCountyList[146]='---------------------------------:0:Baokang:124:Gucheng:122:Laohekou Shi:118:Nanzhang:123:Xiangfan:116:Xiangfan Shi:117:Xiangyang Xian:121:Yicheng Xian:120:Zaoyang:119:';
	aCountyList[147]='---------------------------------:0:Chibi:168:Chongyang:171:Jiayu:169:Tongcheng:172:Tongshan Xian:170:Xianning:167:';
	aCountyList[148]='---------------------------------:0:Anlu Shi:154:Dawu Shi:157:Guangshui:152:Hanchuan Shi:155:Xiaochang:156:Xiaogan Shi:151:Yingcheng:153:Yunmeng Xian:158:';
	aCountyList[149]='---------------------------------:0:Changyang:150:Dangyang:143:Wufeng:149:Xingshan:148:Yichang:145:Yidu:142:Yuanan:147:Zhicheng Shi:144:Zigui:146:';
	aCountyList[150]='---------------------------------:0:Anxiang:50:Changde:45:Hanshou Xian:47:Jinshi:46:Linli:49:Lixian:48:Shimen Xian:52:Taoyuan Xian:51:';
	aCountyList[151]='---------------------------------:0:Changsha:3:Changsha Shi:4:Changsha Xian:1:Liuyang:2:Ningxiang:6:Wangcheng:5:';
	aCountyList[152]='---------------------------------:0:Anren:17:Chenzhou:15:Guidong:22:Guiyang Xian:24:Jiahe Xian:19:Linwu:21:Rucheng:20:Yizhang:18:Yongxing:23:Zixing Shi:16:';
	aCountyList[153]='---------------------------------:0:Changning Xian:9:Hengdong:12:Hengnan Xian:11:Hengshan:13:Hengyang Shi:8:Hengyang Xian:10:Laiyang:7:Qidong:14:';
	aCountyList[154]='---------------------------------:0:Chenxi:94:Hongjiang:91:Huaihua Xian:90:Huitong Xian:92:Jingzhou:100:Mayang Miaozu:101:Tongdao:99:Xinhuang:97:Xupu Xian:95:Yuanling Xian:93:Zhijiang Xian:98:Zhongfang:96:';
	aCountyList[155]='---------------------------------:0:Lengshuijiang Shi:83:Lianyuan Shi:84:Loudi:82:Shuangfeng:86:Xinhua:85:';
	aCountyList[156]='---------------------------------:0:Chengbu:44:Dongkou Xian:37:Longhui Xian:43:Shaodong Xian:36:Shaoyang Shi:41:Shaoyang Xian:42:Suining Xian:39:Wugang:35:Xinning:40:Xinshao:38:';
	aCountyList[157]='---------------------------------:0:Shaoshan:75:Xiangtan Shi:74:Xiangtan Xian:76:Xiangxiang:73:';
	aCountyList[158]='---------------------------------:0:Baojing:67:Fenghuang:62:Guzhang:61:Huayuan Xian:63:Jishou:60:Longshan Xian:64:Luxi:65:Xiangxi:59:Yongshun:66:';
	aCountyList[159]='---------------------------------:0:Anhua:81:Nanxian:79:Taojiang:80:Yiyang:77:Yuanjiang:78:';
	aCountyList[160]='---------------------------------:0:Daoxian:28:Dongan Xian:31:Jianghua:34:Jiangyong:32:Lanshan:29:Ningyuan Xian:27:Qiyang Xian:26:Shuangpai:33:Xintian:30:Yongzhou Shi:25:';
	aCountyList[161]='---------------------------------:0:Huarong Xian:56:Linxiang Xian:53:Miluo:54:Pingjiang Xian:58:Xiangyin:57:Yueyang Xian:55:';
	aCountyList[162]='---------------------------------:0:Cili Xian:88:Sangzhi:89:Zhangjiajie:87:';
	aCountyList[163]='---------------------------------:0:Chalingxian:71:Liling:68:Yanlingxian:70:Youxian:72:Zhuzhou Shi:69:';
	aCountyList[164]='---------------------------------:0:Alxa Meng:1718:Alxa Youqi:1720:Alxa Zuoqi:1719:Ejin Qi:1721:';
	aCountyList[165]='---------------------------------:0:Baotou Shi:1641:Darhan Muminggan:1644:Guyang:1642:Tumd Youqi:1643:';
	aCountyList[166]='---------------------------------:0:Bayannur:1673:Dengkou:1676:Hanggin Houqi:1677:Linhe:1674:Urad Houqi:1678:Urad Houqi:1681:Urad Qianqi:1679:Urad Zhongqi:1680:Wuyuan:1675:';
	aCountyList[167]='---------------------------------:0:Aohan Qi:1650:Ar Horqin Qi:1653:Bairin Youqi:1652:Chifeng Shi:1646:Harqin Qi:1649:Hexigten Qi:1654:Linxi:1648:Ningcheng:1647:Ongniud Qi:1651:';
	aCountyList[168]='---------------------------------:0:Arxan:1724:Hinggan Meng:1722:Horqin Youyi Qianqi:1727:Horqin Youyi Zhongqi:1728:Jalaid Qi:1726:Tuquan:1725:Ulanhot:1723:';
	aCountyList[169]='---------------------------------:0:Hohhot:1634:Hohhot Shi:1635:Horinger:1639:Qingshuihe:1638:Togtoh:1636:Tumd Zuoqi:1640:Wuchuan:1637:';
	aCountyList[170]='---------------------------------:0:Arun Qi:1706:Chen Barag Qi:1702:Erguna:1701:Ewenki Zizhiqi:1708:Genhe:1700:Hailar:1696:Hulun Buir:1695:Manzhouli:1697:Morin Daur:1707:Orenqen Zizhiqi:1705:Xinbarag Yuoqi:1704:Xinbarag Zuoqi:1703:Yakeshi:1698:Zalantun:1699:';
	aCountyList[171]='---------------------------------:0:Dalad Qi:1717:Dongsheng:1710:Ejin Horo Qi:1713:Hanggin:1716:Ih Ju Meng:1709:Jungar Qi:1711:Otog Qi:1714:Otog Qianqi:1715:Uxin Qi:1712:';
	aCountyList[172]='---------------------------------:0:Fengzhen:1664:Horqin Zuoyi:1658:Horqin Zuoyi Houqi:1659:Huade:1669:Hulingol:1656:Hure Qi:1660:Jarud Qi:1662:Jining:1663:Kailu:1657:Liangcheng:1668:Naiman Qi:1661:Qahar Youyi Houqi:1671:Qahar Youyi Zhongqi:1670:Shangdu:1667:Siziwang Qi:1672:Tongliao:1655:Xinghe:1665:Zhouzi:1666:';
	aCountyList[173]='---------------------------------:0:Wuhai Shi:1645:';
	aCountyList[174]='---------------------------------:0:Abag Qi:1686:Dong Ujimqin Qi:1688:Duolun:1685:Erenhot:1684:Sonid Youqi:1690:Sonid Zuoqi:1689:Taibus Qi:1691:Xi Ujimqin Qi:1687:Xianghuang Qi:1694:Xilin Gol:1682:Xilinhot:1683:Zhenglan Qi:1692:Zhengxiangbaiqi:1693:';
	aCountyList[175]='---------------------------------:0:Changzhou Shi:1787:Jintan Xian:1788:Liyang:1789:Wujin Xian:1790:';
	aCountyList[176]='---------------------------------:0:Hongze:1750:Huaian:1747:Huaiyin Xian:1748:Jinhu:1751:Lianshui Xian:1749:Xuyi:1752:';
	aCountyList[177]='---------------------------------:0:Donghai:1743:Ganyu:1745:Guannan:1746:Guanyun:1744:Lianyungang:1742:';
	aCountyList[178]='---------------------------------:0:Gaochun Shi:1732:Jiangning:1730:Jiangpu:1734:Lishui:1731:Luhe Xian:1733:Nanjing:1729:';
	aCountyList[179]='---------------------------------:0:Haian Xian:1768:Haimen Xian:1766:Nantong Shi:1763:Nantong Xian:1762:Qidong:1767:Rudong Xian:1769:Rugao Xian:1764:Tongzhou:1765:';
	aCountyList[180]='---------------------------------:0:Shuyang:1804:Sihong Xian:1806:Siyang Xian:1805:Suqian Shi:1802:Suyu:1803:';
	aCountyList[181]='---------------------------------:0:Changshu:1771:Kunshan:1774:Suzhou:1770:Taicang Xian:1773:Wujiang:1775:Wuxian:1776:Zhangjiagang:1772:';
	aCountyList[182]='---------------------------------:0:Jiangyan:1779:Jingjiang Xian:1780:Taixing:1778:Taizhou Shi:1777:Xinghua Shi:1781:';
	aCountyList[183]='---------------------------------:0:Jiangyin Shi:1793:Wuxi Shi:1791:Wuxi Xian:1792:Xishan:1795:Yixing Shi:1794:';
	aCountyList[184]='---------------------------------:0:Fengxian:1741:Peixian:1740:Pizhou:1736:Suining Xian:1739:Tongshan Xian:1738:Xinyi Shi:1737:Xuzhou Shi:1735:';
	aCountyList[185]='---------------------------------:0:Binhai Xian:1761:Dafeng Xian:1755:Dongtai Shi:1754:Funing Xian:1759:Jianhu Xian:1757:Sheyang Xian:1760:Xiangshui:1758:Yancheng Shi:1753:Yandu:1756:';
	aCountyList[186]='---------------------------------:0:Baoying Xian:1801:Gaoyou Xian:1797:Hanjiang:1800:Jiangdu Xian:1798:Yangzhou:1796:Yizheng:1799:';
	aCountyList[187]='---------------------------------:0:Dantu:1786:Danyang:1783:Jurong Xian:1785:Yangzhong:1784:Zhenjiang Shi:1782:';
	aCountyList[188]='---------------------------------:0:Chongren:471:Dongxiang:466:Fuzhou:459:Fuzhou Shi:460:Guangchang:469:Jinxi Shi:464:Le\'an:463:Lichuan:470:Linchuan Shi:461:Nancheng:465:Nanfeng:462:Yihuang:468:Zixi Xian:467:';
	aCountyList[189]='---------------------------------:0:Anyuan:432:Chongyi:442:Dayu:445:Dingnan:437:Ganxian:433:Ganzhou:428:Huichang:446:Longnan:440:Nankang Xian:430:Ningdu:434:Quannan:444:Ruijin:429:Shangyou:438:Shicheng:431:Xinfeng:443:Xinfeng Xian:441:Xingguo:436:Xunwu:435:Yudu Xian:439:';
	aCountyList[190]='---------------------------------:0:Anfu:480:Jian Xian:473:Jinggangshan:472:Jishui:481:Ninggang:482:Suichuan:479:Taihe:477:Wan\'an:483:Xiajiang:478:Xingan Xian:476:Yongfeng:474:Yongxin:475:';
	aCountyList[191]='---------------------------------:0:Fuliang Xian:399:Jingdezhen:397:Leping:398:';
	aCountyList[192]='---------------------------------:0:De\'an:415:Duchang:416:Hukou:414:Jishui:412:Jiujiang Xian:408:Pengze Xian:411:Ruichang:407:Wuning Xian:410:Xingzi:409:Xiushui:413:';
	aCountyList[193]='---------------------------------:0:Anyi:396:Jinxian Xian:395:Nanchang Shi:393:Nanchang Xian:394:Xinjian Xian:392:';
	aCountyList[194]='---------------------------------:0:Lianhua:401:Luxi:403:Pingxiang Shi:400:Shangli:402:';
	aCountyList[195]='---------------------------------:0:Boyang Xian:420:Dexing Shi:418:Guangfeng:419:Hengfeng:424:Qianshan:422:Shangrao:417:Wannian:427:Wuyuan Xian:421:Yiyang Xian:425:Yugan Xian:423:Yushan Xian:426:';
	aCountyList[196]='---------------------------------:0:Fenyi Xian:448:Xinyu:447:';
	aCountyList[197]='---------------------------------:0:Fengcheng:450:Fengxin:456:Gaoan:452:Jingan:454:Shanggao:458:Tonggu:453:Wanzai:457:Yichun Shi:449:Yifeng:455:Zhangshu:451:';
	aCountyList[198]='---------------------------------:0:Guixi Xian:405:Yingtan:404:Yujiang:406:';
	aCountyList[199]='---------------------------------:0:Baicheng:1523:Da\'an:1524:Taonan:1525:Tongyu:1527:Zhenlai:1526:';
	aCountyList[200]='---------------------------------:0:Baishan:1503:Changtai:1508:Fusong:1506:Jiangyuan:1507:Jingyu:1505:Linjiang:1504:';
	aCountyList[201]='---------------------------------:0:Changchun:1487:Changchun Shi:1488:Dehui Xian:1491:Jiutai:1489:Nongan Xian:1492:Yushu:1490:';
	aCountyList[202]='---------------------------------:0:Huadian:1483:Jiaohe:1484:Jilin Shi:1481:Panshi:1485:Shulan:1482:Yongji:1486:';
	aCountyList[203]='---------------------------------:0:Dongfeng:1530:Dongliao:1529:Liaoyuan:1528:';
	aCountyList[204]='---------------------------------:0:Gongzhuling:1494:Lishu:1496:Shuangliao:1495:Siping:1493:Yitong Manzu:1497:';
	aCountyList[205]='---------------------------------:0:Changling:1520:Fuyu Shi:1521:Qianan:1519:Qianguo:1522:Songyuan:1518:';
	aCountyList[206]='---------------------------------:0:Huinan:1501:Ji\'an:1499:Liuhe:1502:Meihekou:1498:Tonghua Xian:1500:';
	aCountyList[207]='---------------------------------:0:Antu:1516:Dunhua:1512:Helong:1515:Hunchun:1514:Longjing:1513:Tumen:1511:Wangqing:1517:Yanbian:1509:Yanji:1510:';
	aCountyList[208]='---------------------------------:0:Anshan:1351:Haicheng:1352:Tai\'an:1353:Xiuyan:1354:';
	aCountyList[209]='---------------------------------:0:Benxi Manzu:1360:Benxi Shi:1361:Huanren:1362:';
	aCountyList[210]='---------------------------------:0:Beipiao Shi:1397:Chaoyang:1398:Dachengzi:1400:Jianping:1399:Lingyuan:1396:';
	aCountyList[211]='---------------------------------:0:Changhai:1350:Dalian Shi:1346:Pulandian:1348:Wafangdian:1347:Zhuanghe:1349:';
	aCountyList[212]='---------------------------------:0:Dandong:1363:Dandong Shi:1364:Donggang:1365:Fengcheng:1366:Kuandian:1367:';
	aCountyList[213]='---------------------------------:0:Fushan Shi:1356:Fushan Xian:1355:Haicheng:1357:Tai\'an:1358:Xiuyan:1359:';
	aCountyList[214]='---------------------------------:0:Fuxin Mengguzu:1385:Fuxin Shi:1386:Zhangwu:1384:';
	aCountyList[215]='---------------------------------:0:Huludao:1373:Jianchang:1376:Suizhong:1375:Xingcheng:1374:';
	aCountyList[216]='---------------------------------:0:Beining:1370:Heishan Xian:1371:Jinzhou Shi:1368:Linghai:1369:Yixian:1372:';
	aCountyList[217]='---------------------------------:0:Dengta:1387:Liaoyang Shi:1388:Liaoyang Xian:1389:';
	aCountyList[218]='---------------------------------:0:Dawa:1383:Panjin:1381:Panshan:1382:';
	aCountyList[219]='---------------------------------:0:Faku:1343:Kangping:1345:Liaozhong:1344:Shenyang:1341:Xinmin:1342:';
	aCountyList[220]='---------------------------------:0:Changtu:1394:Kaiyuan:1391:Teiling Xian:1393:Tiefa:1390:Tieling Shi:1392:Xifeng:1395:';
	aCountyList[221]='---------------------------------:0:Dashiqiao:1379:Gaizhou:1380:Yingkou Shi:1378:Yingkou Xian:1377:';
	aCountyList[222]='---------------------------------:0:Guyang:2357:Haiyuan:2358:Jingyuan:2361:Longde Xian:2360:Pengyang Xian:2362:Xiji:2359:';
	aCountyList[223]='---------------------------------:0:Huinong:2349:Pingluo:2347:Shizuishan:2346:Taole:2348:';
	aCountyList[224]='---------------------------------:0:Lingwu:2352:Qingtongxiz:2351:Tongxin Xian:2353:Wuzhong:2350:Yanchi:2354:Zhongning:2356:Zhongwei:2355:';
	aCountyList[225]='---------------------------------:0:Helan:2345:Yinchuan Shi:2343:Yongning:2344:';
	aCountyList[226]='---------------------------------:0:Banma:2326:Darlag:2328:Gande:2327:Golog:2324:Jigzhi:2329:Madoi:2330:Maqin:2325:';
	aCountyList[227]='---------------------------------:0:Gangca:2311:Haibei:2308:Haiyan:2309:Menyuan:2312:Qilian:2310:';
	aCountyList[228]='---------------------------------:0:Haidong:2299:Hualong:2306:Huangzhong:2302:Huanyuan:2303:Huzhu:2305:Ledu:2301:Minhe:2304:Pingan:2300:Xunhua:2307:';
	aCountyList[229]='---------------------------------:0:Gonghe:2319:Guide:2321:Guinan:2323:Hainan:2318:Tonghe:2320:Xinghai:2322:';
	aCountyList[230]='---------------------------------:0:Delhi:2338:Dulan:2342:Golmud:2339:Haixi:2337:Tianjun:2341:Ulan:2340:';
	aCountyList[231]='---------------------------------:0:Henan:2317:Huangnan:2313:Jainca:2316:Tongren:2314:Zekog:2315:';
	aCountyList[232]='---------------------------------:0:Datong:2298:Xining Shi:2297:';
	aCountyList[233]='---------------------------------:0:Chindu:2333:Nangqen:2335:Qumarleb:2336:Yushu:2331:Zadoi:2332:Zhidoi:2334:';
	aCountyList[234]='---------------------------------:0:Ankang Shi:2204:Baihe:2212:Hanyin:2213:Lengao:2206:Ningshan:2211:Pingli:2209:Shiquan:2210:Xunyang:2207:Zhenping:2208:Ziyang Xian:2205:';
	aCountyList[235]='---------------------------------:0:Baoji Shi:2129:Baoji Xian:2128:Fengxiang:2130:Fufeng:2132:Linyou:2136:Long:2134:Mei:2133:Qianyang Xian:2135:Qishan:2131:Taibai:2137:';
	aCountyList[236]='---------------------------------:0:Chenggu:2175:Foping:2183:Hanzhong:2173:Liuba:2182:Lueyang:2180:Mianxian:2178:Nanzheng Shi:2174:Ningqiang:2179:Xixiang:2177:Yangxian:2176:Zhenba:2181:';
	aCountyList[237]='---------------------------------:0:Danfeng:2202:Luonan:2200:Shangluo:2196:Shangnan:2201:Shangzhou:2197:Shanyin:2199:Zhashui:2203:Zhennan:2198:';
	aCountyList[238]='---------------------------------:0:Tongchuan Shi:2125:Yaoxian:2126:Yijun:2127:';
	aCountyList[239]='---------------------------------:0:Baishui:2156:Chengcheng:2155:Dali:2153:Fuping Xian:2158:Hancheng:2150:Heyang:2157:Huaxian:2159:Huayin Shi:2151:Pucheng:2154:Tongguan:2152:Weinan Shi:2149:';
	aCountyList[240]='---------------------------------:0:Changan Xian:2120:Gaoling:2121:Huxian:2123:Lantian Xian:2122:Xian:2119:Zhouzhi:2124:';
	aCountyList[241]='---------------------------------:0:Binxian:2144:Changwu Xian:2145:Chunhua:2147:Jingyang Xian:2140:Liquan:2142:Qianxian:2141:Sanyuan:2146:Wugong:2148:Xianyang:2138:Xingping Xian:2139:Yongshou:2143:';
	aCountyList[242]='---------------------------------:0:Anzhai:2161:Fuxian:2169:Ganquan:2168:Huangling:2172:Huanglong:2171:Luochuan:2162:Wuqi:2167:Yanan:2160:Yanchang:2165:Yanchuan:2163:Yichuan:2170:Zhidan:2166:Zichang:2164:';
	aCountyList[243]='---------------------------------:0:Dingpian:2189:Fugu:2186:Hengshan:2187:Jiaxian:2192:Jinbian:2188:Mizhi:2191:Qingjian:2194:Shenmu:2185:Suide:2190:Wubu:2193:Yulin Shi:2184:Zizhou Xian:2195:';
	aCountyList[244]='---------------------------------:0:Binzhou:2074:Boxing:2078:Huimin:2077:Wudi:2080:Yangxin Xian:2079:Zhanhua Xian:2076:Zhouping:2075:';
	aCountyList[245]='---------------------------------:0:Dezhou Shi:2045:Leling:2046:Lingxian:2048:Linyi Xian:2055:Ningjin:2049:Pingyuan:2053:Qihe:2050:Qingyun:2052:Wucheng:2051:Xiajin:2054:Yucheng:2047:';
	aCountyList[246]='---------------------------------:0:Dongying Shi:2102:Guangrao:2104:Kenli:2103:Lijin:2105:';
	aCountyList[247]='---------------------------------:0:Caoxian:2085:Chengwu:2089:Dingtao:2086:Dongming Xian:2088:Heze Shi:2081:Juancheng Xian:2082:Juye Xian:2087:Shanxian:2083:Yuncheng Xian:2084:';
	aCountyList[248]='---------------------------------:0:Changqing:2011:Jinan Shi:2009:Jiyang Xian:2013:Pingyin:2012:Shanghe:2014:Zhangqiu:2010:';
	aCountyList[249]='---------------------------------:0:Jiaxiang:2040:Jining:2034:Jinxiang Xian:2039:Liangshan:2044:Qufu:2035:Sishui:2043:Weishan:2041:Wenshang:2042:Yanzhou:2036:Yutai:2038:Zouxian:2037:';
	aCountyList[250]='---------------------------------:0:Laiwu Shi:2118:';
	aCountyList[251]='---------------------------------:0:Gaotang Xian:2068:Guanxian:2073:Liaocheng Shi:2066:Linqing:2067:Renping:2070:Tong:2072:Xinxian:2071:Yanggu:2069:';
	aCountyList[252]='---------------------------------:0:Cangshan:2060:Feixian:2061:Junan Xian:2063:Linshu:2065:Linyi:2056:Mengyin Xian:2064:Pingyi:2062:Tancheng:2058:Yinan Xian:2057:Yishui Xian:2059:';
	aCountyList[253]='---------------------------------:0:Jiaonan Shi:2091:Jiaozhou Shi:2092:Jimo Shi:2095:Laixi Shi:2094:Pingdu Shi:2093:Qingdao Shi:2090:';
	aCountyList[254]='---------------------------------:0:Juxian:2117:Rizhao:2115:Wulian:2116:';
	aCountyList[255]='---------------------------------:0:Dongping Xian:2114:Feicheng:2112:Ningyang Xian:2113:Taian Shi:2110:Xintai Shi:2111:';
	aCountyList[256]='---------------------------------:0:Anqiu:2019:Changle Xian:2023:Changyi:2021:Gaomi:2020:Linqu Xian:2024:Qingzhou:2016:Shouguang Xian:2018:Weifang:2015:Wulian Xian:2022:Zhucheng Shi:2017:';
	aCountyList[257]='---------------------------------:0:Rongcheng Shi:2109:Rushan:2107:Weihai Shi:2106:Wendeng:2108:';
	aCountyList[258]='---------------------------------:0:Changdao:2033:Haiyang Xian:2032:Laiyang Shi:2027:Laizhou:2028:Longkou Xian:2026:Penglai:2030:Xixia:2031:Yantai:2025:Zhaoyuan:2029:';
	aCountyList[259]='---------------------------------:0:Tengzhou:2101:Zaozhuang Shi:2100:';
	aCountyList[260]='---------------------------------:0:Gaoqing:2098:Huantai:2097:Yiyuan:2099:Zibo Shi:2096:';
	aCountyList[261]='---------------------------------:0:Chongming Xian:2008:';
	aCountyList[262]='---------------------------------:0:Fengxian:2007:';
	aCountyList[263]='---------------------------------:0:Nanhui Xian:2005:';
	aCountyList[264]='---------------------------------:0:Qingpu:2006:';
	aCountyList[265]='---------------------------------:0:Baoshan Qu:1995:Changning:2001:Hongkou:1997:Huangpu:1991:Jinshan Xian:1998:Luwan:1996:Minxing:2004:Naning:2000:Pudong Xinqu:2003:Putuo:1993:Shanghai Shi:1990:Songjiang Xian:1999:Xuhui:1992:Yangpu:1994:Zhabei:2002:';
	aCountyList[266]='---------------------------------:0:Changzhi Shi:1607:Huguan:1610:Licheng:1609:Lucheng:1606:Pingshun Xian:1614:Qinxian:1616:Qinyuan:1612:Tunliu:1615:Wuxiang:1613:Xiangyuan:1608:Zhangzi:1611:';
	aCountyList[267]='---------------------------------:0:Datong:1536:Guangling:1542:Hunyuan:1539:Lingqiu:1537:Tianzhen:1540:Yanggao:1541:Zuoyun:1538:';
	aCountyList[268]='---------------------------------:0:Gaoping:1544:Jincheng Shi:1543:Lingchuan:1546:Qinshui:1548:Yangcheng:1547:Zezhou:1545:';
	aCountyList[269]='---------------------------------:0:Heshun:1599:Jiexiu:1596:Jinzhong:1594:Lingshi Xian:1600:Pingyao:1602:Qixia Xian:1603:Shouyang:1601:Taigu:1604:Xiyang:1597:Yuci Shi:1595:Yushe:1605:Zuoquan:1598:';
	aCountyList[270]='---------------------------------:0:Anze:1630:Daning:1621:Fenxi:1620:Fushan:1626:Guxian:1631:Hongdong:1624:Houma Shi:1618:Huozhou Shi:1619:Jixian:1625:Linfen:1617:Puxian:1629:Quwo:1633:Xiangfen Xian:1627:Xiangning:1628:Xixian:1622:Yicheng:1632:Yonghe:1623:';
	aCountyList[271]='---------------------------------:0:Fenyeng:1566:Jiaocheng:1572:Lanxian:1569:Lanxian:1570:Linxian:1568:Lishi:1564:Luliang:1563:Shilou:1571:Wenshui:1567:Xiaoyi:1565:';
	aCountyList[272]='---------------------------------:0:Huairen:1593:Shanyin:1590:Shuozhou:1589:Yingxian:1592:Youyu:1591:';
	aCountyList[273]='---------------------------------:0:Gujiao:1532:Loufan:1535:Qingxu:1534:Taiyuan Shi:1531:Yangqu:1533:';
	aCountyList[274]='---------------------------------:0:Baode:1554:Daixian:1551:Dingxiang:1558:Fanshi:1557:Hequ:1561:Jingdong:1553:Kelan:1562:Ningwu:1560:Pianguan:1556:Shanchi:1555:Wutai Xian:1552:Wuzhai:1559:Xinzhou:1549:Yuanping Xian:1550:';
	aCountyList[275]='---------------------------------:0:Pingding:1587:Yangquan Shi:1586:Yuxian:1588:';
	aCountyList[276]='---------------------------------:0:Hejin:1574:Jiangxian:1581:Jishan:1584:Linyi Shi:1579:Pinglu:1583:Ruicheng:1578:Wanrang Xian:1585:Wenxi:1576:Xiaxian:1582:Xinjiang:1580:Yongji Xian:1575:Yuangu Xian:1577:Yuncheng:1573:';
	aCountyList[277]='---------------------------------:0:Aba:803:Barkam:799:Heishui:807:Hongyuan:801:Jinchuan:808:Jiuzhaigou:800:Lixian:804:Maoxian:811:Rangtang:810:Songpan:809:Wenchuan:802:Xiaojin:806:Zoige:805:';
	aCountyList[278]='---------------------------------:0:Bazhong Xian:882:Nanjiang:883:Pingchang Xian:884:Tongjiang:885:';
	aCountyList[279]='---------------------------------:0:Chengdu Shi:738:Chongzhou:742:Dayi Xian:750:Dujiangyan:739:Jintang Xian:743:Pengzhou:740:Pixian:745:Qionglai:741:Shuangliu:747:Wenjiang:744:Xindu Xian:748:Xinjin:746:Zhongmou:749:';
	aCountyList[280]='---------------------------------:0:Dachuan:784:Daxian Shi:786:Dazhu Xian:790:Kaijiang:789:Quxian:787:Wanyuan:785:Xuanhan:788:';
	aCountyList[281]='---------------------------------:0:Deyang:858:Guanghan:859:Luojiang:862:Mianzhu Xian:861:Shifang:860:Zhongjiang:863:';
	aCountyList[282]='---------------------------------:0:Baiyu:820:Batang:826:Danba:813:Daocheng:824:Daofu:819:Derong:828:Ganzi:816:Jiulong:815:Kangding:812:Litang:821:Luding:827:Luhuo:814:Seda:825:Shiqu:823:Xiangcheng Xian:822:Xinlong:818:Yajiang:817:';
	aCountyList[283]='---------------------------------:0:Guangan Xian:877:Huaying Shi:878:Linshui Xian:880:Wusheng Xian:881:Yuechi Xian:879:';
	aCountyList[284]='---------------------------------:0:Cangxi Xian:868:Guangyuan Shi:864:Jiange:867:Qingchuan Xian:865:Wangcang:866:';
	aCountyList[285]='---------------------------------:0:Ebian:766:Emeishan:760:Jiajiang:761:Jianwei:763:Jingyan:762:Leshan Shi:759:Mabian:765:Muchuan:764:';
	aCountyList[286]='---------------------------------:0:Butuo:835:Dechang:844:Ganluo:834:Huidong:840:Huili:842:Jinyang:833:Leibo:836:Liangshan Xian:829:Meigu:831:Mianning:845:Muli:846:Ningnan:838:Puge:837:Xichang:830:Xide:839:Yanyuan:843:Yuexi:841:Zhaojue Xian:832:';
	aCountyList[287]='---------------------------------:0:Gulin:857:Hejiang Xian:855:Luxian:854:Luzhou Shi:853:Xuyong:856:';
	aCountyList[288]='---------------------------------:0:Danleng:894:Hongya:893:Meishan:890:Pengshan:892:Qingshen:895:Renshou Xian:891:';
	aCountyList[289]='---------------------------------:0:Anxian:757:Beichuan:756:Jiangyou:752:Mianyang:751:Pingwu:755:Santai Xian:754:Yanting Xian:753:Zitong:758:';
	aCountyList[290]='---------------------------------:0:Langzhong Xian:778:Nanbu Xian:782:Nanchong Shi:776:Nanchong Xian:777:Pengan:780:Xichong Xian:783:Yilong:781:Yingshan:779:';
	aCountyList[291]='---------------------------------:0:Longchang:875:Neijiang Shi:873:Weiyuan Xian:876:Zizhong Shi:874:';
	aCountyList[292]='---------------------------------:0:Miyi:851:Panzhihua Shi:850:Yanbian:852:';
	aCountyList[293]='---------------------------------:0:Daying:872:Pengxi:871:Shehong Xian:870:Suining Shi:869:';
	aCountyList[294]='---------------------------------:0:Baoxing:797:Hanyuan:798:Lushan:792:Mingshan Xian:794:Shimian:793:Tianquan:795:Ya\'an:791:Yingjing Xian:796:';
	aCountyList[295]='---------------------------------:0:Changning:771:Gaoxian:772:Gongxian:770:Jiangan:773:Junlian Xian:774:Nanxi Xian:769:Pingshan Xian:775:Xingwen:768:Yibin Shi:767:';
	aCountyList[296]='---------------------------------:0:Fushan:849:Rongxian:848:Zigong:847:';
	aCountyList[297]='---------------------------------:0:Anyue:888:Jianyang:887:Lezhi:889:Ziyang Xian:886:';
	aCountyList[298]='---------------------------------:0:Baodi:1989:';
	aCountyList[299]='---------------------------------:0:Jinghai:1985:';
	aCountyList[300]='---------------------------------:0:Jixian:1987:';
	aCountyList[301]='---------------------------------:0:Ninghe:1988:';
	aCountyList[302]='---------------------------------:0:Beichen:1982:Dagong:1983:Dongli:1975:Hangu Xian:1979:Hebei:1978:Hedong:1977:Heping:1972:Hexi:1981:Hongqiao:1984:Jinnan:1976:Nankai:1973:Tanggu:1974:Tianjin Shi:1971:Xiping:1980:';
	aCountyList[303]='---------------------------------:0:Wuqing:1986:';
	aCountyList[304]='---------------------------------:0:Dagze:898:Damxung:900:Doilungdeqen:903:Lhasa Shi:896:Lhunzhub:897:Maizhokunggar:902:Nyemo:899:Quxu:901:';
	aCountyList[305]='---------------------------------:0:Amdo:913:Baingoin:912:Baqen:907:Biru:910:Lhari:905:Nagqu:904:Nyainrong:908:Nyima:909:Sog:911:Xainza:906:';
	aCountyList[306]='---------------------------------:0:Burang:962:Coqen:961:Gar:960:Gegyai:963:Gerze:967:Lunggar:965:Ngari:959:Rutog:964:Zanda:966:';
	aCountyList[307]='---------------------------------:0:Bomi:973:Gongbo\'gyamda:974:Mainling:971:Medog:969:Nang:970:Nyingchi:968:Zayu:972:';
	aCountyList[308]='---------------------------------:0:Banbar:922:Baxoi:919:Dengqen:926:Gonjo:917:Jomda:924:Lhorong:923:Markam:916:Putog:918:Qamdo:914:Riwoqe:925:Sinda:921:Toba:928:Yanjing:915:Zhagyab:927:Zogang:920:';
	aCountyList[309]='---------------------------------:0:Comai:932:Cona:939:Gonggar:934:Gyaca:933:Lhozhag:935:Nagarze:940:Nedong:930:Qonggyai:931:Qusum:936:Sanggri:937:Shannan:929:Zhanang:938:';
	aCountyList[310]='---------------------------------:0:Bainang:957:Dinggye:942:Gamba:953:Gyangze:944:Gyirong:949:Kangmar:947:Lhaze:945:Namling:958:Ngamring:952:Nyalam:948:Rinbung:956:Saga:955:Sagya:943:Tinggri:946:Xaitongmoin:951:Xigaze:941:Yadong:950:Zhongba:954:';
	aCountyList[311]='---------------------------------:0:Akesu:2371:Awati:2375:Baicheng:2374:Kalpin:2377:Kuqu:2376:Wensu:2372:Wushi:2379:Xayat:2373:Xinhe:2378:';
	aCountyList[312]='---------------------------------:0:Altay:2443:Burqin:2447:Fuhai:2448:Fuyun:2446:Habahe:2449:Jeminary:2445:Qinghe:2444:';
	aCountyList[313]='---------------------------------:0:Bayingolin:2392:Bohu:2398:Hejing:2394:Hoxud:2396:Korla:2393:Luntai:2399:Qiemo:2397:Ruoqiang:2400:Yanqi:2401:Yuli:2395:';
	aCountyList[314]='---------------------------------:0:Bole:2439:Bortala:2438:Jinghe:2440:Wenquan:2441:';
	aCountyList[315]='---------------------------------:0:Changji Hui:2402:Fukang:2403:Hutubi:2408:Jimsar:2407:Manas:2406:Miquan:2404:Mori:2409:Qitai:2405:';
	aCountyList[316]='---------------------------------:0:Barkol:2432:Hami:2430:Yiwu:2431:';
	aCountyList[317]='---------------------------------:0:Hotan Xian:2364:Luopu:2365:Minfeng:2366:Moyu:2370:Pishan:2367:Qira:2368:Yutian:2369:';
	aCountyList[318]='---------------------------------:0:Karamay Shi:2425:';
	aCountyList[319]='---------------------------------:0:Bachu:2381:Jiashi:2383:Kashi:2380:Markit:2387:Shache:2389:Shufu:2390:Shule:2386:Taxkorgan:2391:Yecheng:2384:Yengisar:2388:Yopugar:2385:Zepu:2382:';
	aCountyList[320]='---------------------------------:0:Akqi:2435:Akto:2437:Artux:2434:Kizilsu:2433:Wuqia:2436:';
	aCountyList[321]='---------------------------------:0:Kuytun:2442:';
	aCountyList[322]='---------------------------------:0:Gongliu:2417:Huocheng:2416:Lli Kazar:2410:Nileke:2413:Qapcal:2418:Tekesi:2412:Xinyuan:2415:Yining Shi:2411:Zhaosu:2414:';
	aCountyList[323]='---------------------------------:0:Shihezi:2426:';
	aCountyList[324]='---------------------------------:0:Emin:2421:Oboksar:2424:Shawan:2423:Tacheng:2419:Usu:2420:Yumin:2422:';
	aCountyList[325]='---------------------------------:0:Shanshan:2429:Toksun:2428:Turpan:2427:';
	aCountyList[326]='---------------------------------:0:Urumqi Shi:2363:';
	aCountyList[327]='---------------------------------:0:Baoshan:584:Changning:586:Longning:587:Shidian:585:Tengchong Xian:588:';
	aCountyList[328]='---------------------------------:0:Chuxiong:544:Chuxiong Shi:545:Datao:550:Lufeng Xian:552:Mouding:548:Nanhua:547:Shuangbai:551:Taoan:554:Wuding:549:Yongren:553:Yuanmou:546:';
	aCountyList[329]='---------------------------------:0:Binchuan Xian:561:Dali:555:Eryuan:559:Jianchuan:556:Midu:557:Nanjian:565:Weishan:564:Xiangyun:560:Yangbi:563:Yongping:562:Yunlong:558:';
	aCountyList[330]='---------------------------------:0:Dehong:597:Lianghe:602:Longchuan:603:Luxi Xian:598:Ruili:600:Wanding:599:Yingjiang:601:';
	aCountyList[331]='---------------------------------:0:Deqin Xian:611:Diqing:609:Weixi:612:Zhongdian:610:';
	aCountyList[332]='---------------------------------:0:Geijiu:531:Hekou:542:Honghe:534:Jianshui Xian:538:Jinping:541:Kaiyuan:532:Luchun:535:Luxi:537:Mengzi:536:Mile:533:Pingbian:543:Shiping:540:Yuanhe:539:';
	aCountyList[333]='---------------------------------:0:Anning:486:Chenggong:489:Fumin Xian:487:Jinning:490:Kunming:484:Kunming Shi:485:Luquan:492:Shilin:493:Songmimg:488:Xundian:494:Yiliang:491:';
	aCountyList[334]='---------------------------------:0:Huaping:589:Lijiang:591:Ninglang:592:Yongshen:590:';
	aCountyList[335]='---------------------------------:0:Cangyuan:522:Fengqing Xian:518:Gengma:523:Lincang:516:Shuangjiang:521:Yongde:520:Yunxian:519:Zhenkang:517:';
	aCountyList[336]='---------------------------------:0:Fugong:606:Gongshan:608:Lanping:607:Lushui:605:Nujiang:604:';
	aCountyList[337]='---------------------------------:0:Fuyuan:570:Huize Xian:569:Louping:571:Luliang:568:Malong:572:Qujing Shi:566:Shizong:573:Xuanwei:567:Zhanyi:574:';
	aCountyList[338]='---------------------------------:0:Jiangcheng:514:Jingdong:508:Jinggu:510:Lancang:512:Menglian:515:Mojiang:511:Puer:507:Simao:506:Ximeng:513:Zhenyuan:509:';
	aCountyList[339]='---------------------------------:0:Funing:528:Guangnan:526:Maguan:527:Malipo:525:Qiubei:530:Wenshan:524:Xichou:529:';
	aCountyList[340]='---------------------------------:0:Jinghong Xian:594:Menghai:595:Mengla:596:Xishuangbana:593:';
	aCountyList[341]='---------------------------------:0:Chengjiang:577:Eshan:583:Huaning:576:Jiangchuan:580:Tonghai:579:Xinping:582:Yimen:578:Yuanjiang:581:Yuxi:575:';
	aCountyList[342]='---------------------------------:0:Daguan:499:Ludian:505:Qiaojia:501:Shuifu:504:Suijiang Xian:497:Weixin:503:Yanjin:500:Yiliang:502:Yongshan Xian:496:Zhaotong:495:Zhenxiong:498:';
	aCountyList[343]='---------------------------------:0:Chun\'an:1075:Chun\'an:1100:Fuyang:1096:Fuyang Shi:1071:Hangzhou:1093:Hangzhou Shi:1068:Jiande:1070:Jiande:1095:Lin\'an:1098:Lin\'an Xian:1073:Tonglu:1099:Tonglu Xian:1074:Xiaoshan:1069:Xiaoshan:1094:Yuhang:1097:Yuhang Xian:1072:';
	aCountyList[344]='---------------------------------:0:Anji:1150:Changxing Xian:1148:Deqing:1149:Huzhou:1147:';
	aCountyList[345]='---------------------------------:0:Haining:1142:Haiyan Xian:1146:Jiashan Xian:1145:Jiaxing Shi:1141:Pinghu:1143:Tongxiang Xian:1144:';
	aCountyList[346]='---------------------------------:0:Dongyang Shi:1119:Jinhua Xian:1121:Lanxi:1117:Pan\'an:1124:Pujiang:1123:Wuyi:1122:Yiwu:1118:Yongkang Xian:1120:';
	aCountyList[347]='---------------------------------:0:Jingning:1140:Jinyun Xian:1134:Lishui Shi:1132:Longguan:1133:Qingtian:1135:Qingyuan Shi:1139:Songyang:1138:Suichang Xian:1137:Yunhe:1136:';
	aCountyList[348]='---------------------------------:0:Cixi Shi:1078:Cixi Shi:1103:Fanghua:1079:Fenghua:1104:Ningbo:1101:Ningbo Shi:1076:Ninghai:1081:Ninghai Xian:1106:Xiangshan:1082:Xiangshan:1107:Yinxian:1080:Yinxian:1105:Yutao:1077:Yutao:1102:';
	aCountyList[349]='---------------------------------:0:Changshan:1160:Danhua:1161:Jiangshan:1157:Longyou:1159:Quxian:1158:Quzhou:1156:Shangyu Xian:1152:Shaoxing Xian:1154:Shengzhou:1153:Xinchang:1155:Zhuji Shi:1151:';
	aCountyList[350]='---------------------------------:0:Linhai:1126:Sanmen Xian:1131:Taizhou:1125:Tiantai Xian:1129:Wenling:1127:Xianju:1130:Yuhuan:1128:';
	aCountyList[351]='---------------------------------:0:Cangnan:1090:Cangnan:1114:Dongtou:1088:Dongtou:1112:Leqing:1110:Leqing Xian:1086:Pingyang:1113:Pingyang Xian:1089:Rui\'an:1109:Rui\'an Shi:1085:Taishun:1092:Taishun:1116:Wencheng:1115:Wencheng Xian:1091:Wenzhou:1083:Wenzhou:1108:Wenzhou Shi:1084:Yongjia:1111:Yongjia Xian:1087:';
	aCountyList[352]='---------------------------------:0:Daishan:1163:Shengsi:1164:Zhoushan:1162:';
	
	markPassedSelections(document.forms[0].InitialProvince.value,document.forms[0].InitialDistrict.value,document.forms[0].InitialCounty.value);
}


function markPassedSelections(selectedProvince, selectedDistrict, selectedCounty) {
	
	var province_selbox = document.forms[0].province;
	var district_selbox = document.forms[0].district;
	var county_selbox = document.forms[0].county;
	
	fillSelectBox( province_selbox, sProvinceList, selectedProvince );
	fillSelectBox( district_selbox, aDistrictList[selectedProvince], selectedDistrict );
	fillSelectBox( county_selbox, aCountyList[selectedDistrict], selectedCounty );
	
}


function setDistrictChoices(provinceSelection) {
// This function will update the district and county choices based on the users's province selection.

	var district_selbox = document.forms[0].district;

	fillSelectBox( district_selbox, aDistrictList[provinceSelection]) ;

	// Display the county list for the first District shown in the District drop-down list.
	// This is done since the user has just choose a province and the first choice in the
	// district list will be the initial selection.
	setCountyChoices(0);

}


function setCountyChoices(districtSelection) {
// This function will update the county choices based on the user's district selection.

	var county_selbox = document.forms[0].county;
	
	fillSelectBox( county_selbox, aCountyList[districtSelection]);

}


function fillSelectBox( selbox, sList, selvalue) {
// This function will take the values in sList and populate the drop-down list selbox.
	
	var tempChoice;
	var tempValue;
	var pos;
	
	// Clear current values from select box
	selbox.options.length = 0;
	
	if (sList != '') {
		pos = sList.indexOf(':');
		tempChoice = sList.substring(0,pos);
		sList = sList.substring(pos+1);
		pos = sList.indexOf(':');
		tempValue = sList.substring(0,pos);
		sList = sList.substring(pos+1);
		if (tempValue == selvalue)
			selbox.options[selbox.options.length] = new Option(tempChoice,tempValue,false,true);
		else
			selbox.options[selbox.options.length] = new Option(tempChoice,tempValue,false,false);
	}
	
	while (sList != '') {
		pos = sList.indexOf(':');
		tempChoice = sList.substring(0,pos);
		sList = sList.substring(pos+1);
		pos = sList.indexOf(':');
		tempValue = sList.substring(0,pos);
		sList = sList.substring(pos+1);
		if (tempValue == selvalue)
			selbox.options[selbox.options.length] = new Option(tempChoice,tempValue,false,true);
		else
			selbox.options[selbox.options.length] = new Option(tempChoice,tempValue,false,false);
	}
	
}


function findpositioninlist(tempstring,lookingfor) {
// This function will search through the passed tempstring and find the list position for
// the value stored in lookingfor and then return this position as an integer.
	
	var pos;
	
	pos = tempstring.indexOf(lookingfor+':');
	tempstring = tempstring.substring(pos+lookingfor.length+1);
	pos = tempstring.indexOf(':');
	tempstring = tempstring.substring(0,pos);
	
	return parseInt(tempstring);
	
}
