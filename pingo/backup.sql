drop database if exists pingo;
create database pingo DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use pingo;

#顾客
create table customer(                          
    email     varchar(32) primary key,          #账号
    name      varchar(32) not null,             #姓名
    password  char(40) not null,                #密码 sha1
    profile   varchar(255)                      #自我介绍
);

#设置
create table settings(
    customer_email varchar(32) primary key,          #账号
    mail_1 tinyint unsigned ,
    mail_2 tinyint unsigned ,
    mail_3 tinyint unsigned ,
    mail_4 tinyint unsigned ,
    sound_1 tinyint unsigned ,
    sound_2 tinyint unsigned ,
    sound_3 tinyint unsigned ,
    sound_4 tinyint unsigned 
);

#地址
create table addr(
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    customer_email  varchar(32) not null,          #账号
    consignee       varchar(32) not null,
    province        varchar(16) not null,
    city            varchar(16) not null,
    detail          varchar(256) not null,
    postcode        varchar(6)  ,
    phone           varchar(20) not null
);

#商品
create table product (                        
    id          varchar(64) primary key,                #商品编号
    name        varchar(256) not null,                  #英文名称
    ch_name     varchar(256) not null,                  #中文名称
    price       DECIMAL(10, 2) not null,                #商品价格
    description varchar(256) not null,                  #英文描述
    ch_description varchar(256) not null,               #中文描述
    unit        varchar(32) not null,                   #英文计量单位
    ch_unit     varchar(32) not null,                   #中文计量单位
    kind        varchar(16) not null,                   #英文类别
    ch_kind     varchar(16) not null,                   #中文类别
    addr        varchar(256) not null,                  #英文发货地址
    ch_addr     varchar(256) not null,                  #中文发货地址                 
    shop_id     varchar(16) not null                    #店铺编号
);
ALTER TABLE product ADD INDEX product_index1 (name,kind,price); #为了方便商品检索添加的索引

#店铺                   
create table shop(                              
    id varchar(20) primary key,                 #账号
    addr varchar(255) not null,                 #地址
    tele varchar(20) not null                   #电话
);

#红包
create table packet(                            
    product_id varchar(64) primary key,             #店铺编号                        
    lim         DECIMAL(10,2) not null,               #满
    off         DECIMAL(10,2) not null                #减
);

#购物车
create table cart(                              
    customer_email  varchar(32),                    #顾客账号
    product_id    varchar(64),                      #商品编号
    quantity        int unsigned not null,          #数量
    primary key (customer_email,product_id) 
);

create table pingo(
    id int unsigned PRIMARY KEY AUTO_INCREMENT,
    customer_email  varchar(32),                    #顾客账号
    product_id      varchar(64),                      #商品编号
    addr_id         int unsigned,
    quantity        int unsigned not null,              #数量
    createtime      datetime   not null              #创建时间
);
ALTER TABLE pingo ADD UNIQUE (customer_email,product_id,addr_id);

create table message(
    customer_email varchar(32) not null, 
    type tinyint unsigned not null #0 failed 1 can pay 2 order success 
);

create table progress(
    id                          char(40) ,                  #编号
    product_id                  varchar(64) ,               #商品编号
    product_name                varchar(256) not null,      #英文名称
    product_ch_name             varchar(256) not null,      #中文名称
    product_price               DECIMAL(10, 2) not null,    #商品价格
    product_description         varchar(256) not null,      #英文描述
    product_ch_description      varchar(256) not null,      #中文描述
    product_unit                varchar(32) not null,       #英文计量单位
    product_ch_unit             varchar(32) not null,       #中文计量单位
    product_kind                varchar(16) not null,       #英文类别
    product_ch_kind             varchar(16) not null,       #中文类别
    product_addr                varchar(256) not null,      #英文发货地址
    product_ch_addr             varchar(256) not null,      #中文发货地址                 
    quantity                    int unsigned not null,      #商品数量
    customer_email              varchar(32) not null,       #购买顾客
    customer_name               varchar(32) not null,
    addr_id                     int unsigned not null,      #地址
    addr_consignee              varchar(32) not null,       #收货人
    addr_province               varchar(16) not null,       #省
    addr_city                   varchar(16) not null,       #市
    addr_detail                 varchar(256) not null,      #其他
    addr_postcode               varchar(6)  ,               #邮政编码
    addr_phone                  varchar(20) not null,       #电话
    lim                         DECIMAL(10,2) not null,     #满
    off                         DECIMAL(10,2) not null,     #减
    original                    DECIMAL(10,2) not null,     #总原价
    agreed                      tinyint unsigned,           #0 unknown 1 failed 2 success
    status                      tinyint unsigned,           #0 unknown 1 failed 2 success
    payed                       tinyint unsigned,           #0 no 1 yes
    remove                      tinyint unsigned,           #0 no 1 yes
    primary key(id,product_id,addr_id)
);

#订单
create table orders(                            
    id varchar(128) primary key,                #订单编号
    original DECIMAL(10,2) not null,            #总原价
    benefits DECIMAL(10,2) not null,            #总优惠
    createtime datetime   not null              #创建时间
);
ALTER TABLE orders ADD INDEX orders_index1 (createtime); #为了方便 按时间 查询订单添加的索引

#订单详细信息
create table orderdetail(                     
    orders_id                   varchar(128) not null,      #订单编号
    product_id                  varchar(64) primary key,    #商品编号
    product_name                varchar(256) not null,      #英文名称
    product_ch_name             varchar(256) not null,      #中文名称
    product_price               DECIMAL(10, 2) not null,    #商品价格
    product_description         varchar(256) not null,      #英文描述
    product_ch_description      varchar(256) not null,      #中文描述
    product_unit                varchar(32) not null,       #英文计量单位
    product_ch_unit             varchar(32) not null,       #中文计量单位
    product_kind                varchar(16) not null,       #英文类别
    product_ch_kind             varchar(16) not null,       #中文类别
    product_addr                varchar(256) not null,      #英文发货地址
    product_ch_addr             varchar(256) not null,      #中文发货地址                 
    quantity                    int unsigned not null,      #商品数量
    customer_email              varchar(32) not null,       #购买顾客
    addr_id                     int unsigned not null,      #地址
    addr_consignee              varchar(32) not null,       #收货人
    addr_province               varchar(16) not null,       #省
    addr_city                   varchar(16) not null,       #市
    addr_detail                 varchar(256) not null,      #其他
    addr_postcode               varchar(6)  ,               #邮政编码
    addr_phone                  varchar(20) not null,       #电话
    lim                         DECIMAL(10,2) ,             #满
    off                         DECIMAL(10,2) ,             #减
    original                    DECIMAL(10,2) not null,     #总原价
    benefits                    DECIMAL(10,2) not null      #总优惠
);
ALTER TABLE orderdetail ADD INDEX orderdetail_index1 (orders_id,customer_email); #为了方便 按顾客 查询订单添加的索引

#订单不添加外键 不需要级联删除或者修改
alter table product   add constraint product_fkey1 foreign key(shop_id)         references shop(id);
alter table packet    add constraint packet_fkey1    foreign key(product_id)    references product(id);
alter table cart      add constraint cart_fkey1      foreign key(product_id)    references product(id);
alter table cart      add constraint cart_fkey2      foreign key(customer_email)  references customer(email);
insert into shop values("1","上海市嘉定区","110");

#insert into product values("id","name","名称","100","description","描述","unit","单位","kind","类别","addr","地址","1");
#food
insert into product values("1","Sunchips Multigrain Snacks Variety Pack, Pack of 30","小吃品种包,30包","22","Mix includes 1.5 ounce bags of: SUNCHIPS French Onion, SUNCHIPS Garden Salsa, SUNCHIPS Harvest Cheddar, and SUNCHIPS Original","混合包中42g袋：原味、洋葱、番茄、烧烤、香辣","packet","包","food","食品","addr","北京市朝阳区","1");
insert into product values("2","Anjou Organic Coconut Oil, Cold Pressed Unrefined","Anjou有机椰子油,冷榨未精制,特级处女美容,烹饪,健康,狗,DIY乳液,头发,皮肤","23","500ml","500毫升/罐","can","罐","food","食品","addr","北京市朝阳区","1");
insert into product values("3","Diet Coke Fridge Pack Cans, 12 Count, 12 fl oz","饮料可乐冰箱包罐,12罐","28","Pack of twelve, 12 FL OZ per can","每箱12罐250ml","packet","听","food","食品","addr","北京市朝阳区","1");
insert into product values("4","Oreo Double Stuf Chocolate Sandwich Cookies, 15.35 Ounce","奥利奥双层巧克力三明治饼干","435g","8","One 15.35-ounce pack (30 cookies)","435g（30个饼干）","packet","包","food","食品","addr","北京市朝阳区","1");
insert into product values("5","Skittles Original Candy, 9 ounce bag","彩虹糖225g装","5","original 225g","原味225g","packet","包","food","食品","addr","北京市朝阳区","1");
insert into product values("6","Ferrero Rocher Hazelnut Chocolates, 48 Count","费列罗榛子巧克力,48个/盒","140","48-Count Gift Box","礼盒（48个）","packet","盒","food","食品","addr","北京市朝阳区","1");
insert into product values("7","M&M'S Peanut Chocolate Candy Party Size 42-Ounce Bag (Pack of 2)","M＆M'S花生巧克力糖果1190g包（2包）","100","42-Ounce Bag pack of 2","2包入（1190g/包）","packet","包","food","食品","addr","北京市朝阳区","1");
insert into product values("8","Mixed Nuts Gift Baskets and Seeds Holiday Gift Tray 12 Variety Gift Baskets","混合坚果礼品篮和种子假日礼品托盘12种礼品篮子","39","12 varities,30g/varity","30g/种,12种混合","packet","包","food","食品","addr","北京市朝阳区","1");

#electronic
insert into product values("9","Canon EOS REBEL T7i EF-S 18-55 IS STM Kit","佳能EOS REBEL T7i EF-S 18-55 STM套装","5094","w/ 18-55mm","w/ 18-55mm","packet","台","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("10","Apple Certified Lightning to USB Cable - 6 Feet (1.8 Meters) - White","苹果USB接线 - 6脚（1.8米）-白色","40","white/6 feet ","白色/6脚","packet","根","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("11","Bluetooth Headset Headphone Invisible Wireless Earbud Earpiece Earphone","蓝牙耳机 隐形 无线 耳机耳塞","119","pink","玫瑰金 带替换耳塞","packet","对","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("12","Car Mount Air Vent Mount Cell Phone Car Holder ","车载手机支架 5存 5.5寸 6寸 6.5寸","35","5.5 black","5.5寸 黑色","packet","台","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("13","CT Sounds 2.0 Dual 12 Inch Subwoofer Bass Package in Ported Box with Amplifier","CT声音2.0双12英寸低音炮低音炮包装在带放大器的便携式盒子中","248","dual 12 inch 2.0","12英寸 2.0","packet","台","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("14","Fusion MS-RA200MP DIN Mounting Plate for MS-RA200","MS-RA200/MS-RA200MP DIN视频安装板","96"," msra200mp black"," msra200mp 黑色框","packet","个","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("15","Epson Expression Home XP-330 Wireless Color Photo Printer with Scanner and Copier","爱普生XP-330无线彩色照片打印机带扫描仪和复印机","269","black","黑色","packet","台","electronic","电子产品","addr","北京市朝阳区","1");
insert into product values("16","ASUS RT-ACRH13 Dual-Band 2x2 AC1300 Wifi 4-port Gigabit Router with USB 3.0","华硕RT-ACRH13双频2x2 AC1300 Wifi 4端口千兆路由器,带USB 3.0","199","4port black","四口 黑色","packet","台","electronic","电子产品","addr","北京市朝阳区","1");

#clothes
insert into product values("17","Lucky Brand Women's Floral Triangle Tee","幸运女装花三角T恤","39","pink L","粉色 L","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("18","GRACE KARIN Women Pleated Vintage Skirts Floral Print CL6294","GRACE KARIN女士褶皱复古裙子花卉印花CL6294","139","color-5 L","颜色5 L","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("19","Womens Bootcut Stretch Dress Pants - Comfy Pull On Style, Red Hanger","女装弹力连衣裤 - 舒适拉式,红色衣架","102","Brown M","棕色 M","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("20","Columbia Women's Arcadia II Jacket","哥伦比亚女子阿卡迪亚II夹克","213","Lychee M","浅粉 M","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("21","7 For All Mankind Women's Roll up Short-Squiggle","7全人类女子牛仔短裤","149","light-sky L","浅蓝 L","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("22","PattyBoutik Women's Scoop Neck Cut Out Flutter Sleeve Blouse","PattyBoutik女式镂空领镂空袖衬衫","69","black M","黑色 M","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("23","AG Adriano Goldschmied Women's the Prima Mid Rise Cigarette Stretch Sateen","AG Adriano Goldschmied女士卷烟牛仔裤","178","blue L","牛仔蓝 L","packet","件","clothes","服装","addr","北京市朝阳区","1");
insert into product values("24","Eedor Women's 3 to 8 Pack Thin Casual No Show Socks Non Slip Flat Boat Line","女士3至8包薄休闲不显示袜子非滑平线","9.99","3 Pack_beige","3双/包","packet","包","clothes","服装","addr","北京市朝阳区","1");

#fashion
insert into product values("30","Dior Lipstick Lipstick Lip Gloss,a tube","Dior 迪奥唇膏口红唇彩,一管","298","Dior first introduced lipstick, can continue to natural lip color, is personalized lipstick. Dior charm lips lipstick, according to the degree of water to make a response to the lips, the performance of vivid colors and healthy lips.","迪奥第一次推出的唇膏,能持续自然唇色,是个性化唇膏。迪奥魅惑丰唇蜜膏,可根据嘴唇的水分程度做出反应,表现生动颜色和健康嘴唇。","tube","管","fashion","个性美护","addr","北京市朝阳区","1");
insert into product values("31","SK-II Skin Care Essence,a bottle","SK-II 护肤精华露 神仙水,250ml/一瓶","1038","Fairy water is SK-II ace classic, is also highly sought after, award-winning best-selling products. SK2 Skin Care Essence Contains 90% natural extract of Pitera, a component that has been discovered for more than 30 years and ever used.","神仙水是SK-II的皇牌经典,也是备受追捧、屡获殊荣的畅销产品。SK2护肤精华露蕴含90%天然萃取物Pitera?,那是一种发现于30多年前且沿用至今的成分。","bottle","瓶","fashion","个性美护","addr","北京市朝阳区","1");
insert into product values("32","Calvin Klein(Light) perfume","卡尔文克雷恩卡莱优(淡)香水100ml","306","Lasting fragrance, distributed charming fragrance","持久芬芳,散发默认香味","瓶","bottle","fashion","个性美护","addr","地址","1");
insert into product values("33","Dettol Droop Healthy Moisturizing Lotion 935g + 935g Special Value Two Bottles Sale","Dettol 滴露 健康沐浴露滋润倍护935g+935g 超值特惠两瓶装 特卖","39.9","Suitable for the whole family every day, so that you feel at ease hundred percent","适合全家每天使用,让你安心百分百","set","套","fashion","个性美护","addr","地址","1");
insert into product values("34","OPI Nail polish","OPI 指甲油","249","Breakfast at Tiffany 's Tiffany' s Breakfast Set 10.75ml * 10"," Breakfast at Tiffany's蒂凡尼的早餐十色套装 3.75ml*10","ml","毫升","fashion","个性美护","addr","地址","1");
insert into product values("35","PARI YUNSOO French Ballet Elements Crystal Kiss","PARI YUNSOO法国芭黎元素 水晶之吻","38","3.8g lipstick 6 colors can not easily fade lasting moisturizing moisturizing lip gloss lasting moisturizing desalination lip (mousse red)","3.8g 口红6色可选 不易掉色持久保湿 滋润唇彩持久补水保湿淡化唇纹 (慕斯红)","tube","管","fashion","个性美护","addr","地址","1");
insert into product values("36","Camellia fruit liquid bath soap","山茶果 液态沐浴皂","68","100ML travel equipment essential oil shower gel liquid hand soap","100ML旅行装 精油沐浴露 液体手工皂","ml","毫升","fashion","个性美护","addr","地址","1");
insert into product values("37","Maybelline eye and lip makeup remover","美宝莲眼部卸妆液","51","150ml, sold and shipped directly from Amazon.","每瓶150ml,直接发货","bottle","瓶","fashion","个性美护","addr","地址","1");

#furniture
insert into product values("38","Barbecue family portable director chair beach chair canvas chair outdoor aluminum folding chair","烧烤世家 便携导演椅沙滩椅子帆布椅 户外铝合金折叠椅","169","Lightweight aluminum comfortable folding chairs, double Oxford cloth, tear-resistant, waterproof wear-resistant, anti-aging!","轻便铝制舒适折叠椅,双股牛津布,抗撕裂、防水耐磨、耐老化！","set","套","furniture","家具","addr","地址","1");
insert into product values("39","Sikai scaler outdoor single hammock","思凯乐 scaler 户外 单人吊床","69","Thicker Canvas Hammock Swing Bed with Bundle Bags Z6532010","加厚帆布吊床 秋千床 附赠绑绳收纳袋 Z6532010","set","套","furniture","家具","addr","地址","1");
insert into product values("40","Legon Japanese tatami","乐昂 日式榻榻米","328","Can be folded lazy sofa reliable back floating window chair cloth steel frame sofa bed (205 cm long version of gift pillow) NL-SF (supplier direct delivery）","可折叠懒人沙发 可靠背飘窗椅 布艺钢架沙发床（205厘米加长版 赠抱枕） NL-SF (供应商直送)","set","套","furniture","家具","addr","地址","1");
insert into product values("41","KANSOON Kai speed office lunch bed folding bed","KANSOON 凯速 办公室午休床折叠床","157.1","Ten King Bed Single Rowing Bed Outdoor Camping Escape Bed Household Beach Bed Storage Bag Design With Eye Mask Dust Cover HG37 Gray (Vendor Direct)","十角床单人行军床 户外野营 陪护床家用 沙滩床 收纳袋设计 附赠眼罩防尘罩 HG37 灰色(供应商直送)","set","张","furniture","家具","addr","地址","1");
insert into product values("42","KANSOON Kaiser Mazar","凯速马扎","25","Double canvas cross reinforcement portable outdoor folding stool Mazar travel trip black 【send bag】","双层帆布 十字加固 便携户外折叠凳子 马扎旅行出游 黑色【送收纳袋】","set","套","furniture","家具","addr","地址","1");
insert into product values("43","Leang lazy sofa chair","乐昂 懒人沙发椅","309","Home armchair Japanese home tatami (custom plus long section, a pillow pillow) (supplier direct delivery)","家居扶手椅 日式家居榻榻米（定制加长款,赠抱枕一个）(供应商直送)","set","套","furniture","家具","addr","地址","1");
insert into product values("44","Westfield outdoor folding bed","Westfield outdoor 美式折叠床","299","Adjustable backrest","可调节靠背","set","套","furniture","家具","addr","地址","1");
insert into product values("45","Captain Stag","Captain Stag 焦耳躺椅 ","85.1","Type2 M-3846 black (Amazon imported straight, Japanese brand)","Type2 M-3846 black (Amazon imported straight, Japanese brand)","set","套","furniture","家具","addr","地址","1");

#fitness
insert into product values("46","KANSOON KS-KA05-type mute two-wheeled bones","KANSOON 凯速 KS-KA05型 静音双轮健腹轮","29.9","Beauty belly thin abdominal muscles with 1cm thick non-slip mats prisoners fitness","美腹瘦腹腹肌轮 带1cm加厚防滑垫 囚徒健身","set","套","fitness","健康","addr","地址","1");
insert into product values("47","Kay speed yoga mat","凯速 瑜伽垫","49.9","NBR / TPE high density yoga mat pedal puller free exercise fitness mat","NBR/TPE高密度瑜伽垫 脚蹬拉力器自由运动健身垫","set","套","fitness","健康","addr","地址","1");
insert into product values("48","PROIRON home dumbbells","PROIRON 家用哑铃","47","Yoga lady male color dip matte dumbbell 1-15LB lady dumbbell","瑜伽 女士男 彩色浸塑磨砂哑铃1-15LB女士哑铃","set","套","fitness","健康","addr","地址","1");
insert into product values("49","SUNNY HEALTH&FITNESS Climbing machine","登山机","937","High-level stepper machine can be folded storage SF-1115 silver [classic treadmill high-level training necessary) (supplier direct delivery)","高阶踏步机 可折叠收纳 SF-1115 银色【经典款 踏步机高阶训练必备】（供应商直送）","set","套","fitness","健康","addr","地址","1");

#books
insert into product values("50","Sherlock: The Casebook","神探夏洛克","91.70"," Mystery & Thrillers,British Detectives","推理与惊悚小说","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("51","Harry Potter and the Sorcerer's Stone (Book 1)","哈利·波特与魔法石","43.60","Children's Books·Fantasy & Magic","儿童图书·魔幻玄学小说","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("52","Big Little Lies","大小谎言","48.20","Literature & Fiction·Women's Fiction","文学与虚构类·女性小说","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("53","我们都是孤独的行路人","我们都是孤独的行路人","25.30","author:周国平；philosophy;Essays","作者：周国平；哲学、随笔杂文","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("54","C Primer Plus","C Primer Plus(中文版)","68.50","Programming and development ","编程与开发","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("55","The Kite Runner","追风筝的人","21.40","author:Khaled Hosseini","作者：卡勒德?胡赛尼","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("56","我们仨","我们仨","17.20","author：杨绛","作者：杨绛","packet","本","books","书本","addr","北京市朝阳区","1");
insert into product values("57","Ferryman","摆渡人","57.80","author:Claire McFall;Literature & Fiction","作者：Claire McFall;[英文原版]心灵治愈系小说","packet","本","books","书本","addr","北京市朝阳区","1");

#home
insert into product values("58","Candy&Sarah Non printing leisure carpet","贝好莱 无印水洗纱布提花休闲毯 ","198","180*220cm","标准 180*220cm","packet","条","home","家居","addr","北京市朝阳区","1");
insert into product values("59","IRIS Five layers of environmental protection plastic drawer type baby wardrobe storage cabinet","IRIS 爱丽思 五层环保塑料抽屉式宝宝衣柜收纳储物柜子","480","White frame + log color top","白色框架+原木色顶","packet","个","home","家具","addr","北京市朝阳区","1");
insert into product values("60","HAYASHI Japan imported cotton towel 1350g 6 suite","HAYASHI 日本原装进口1350g纯棉毛巾方巾浴巾6件组合套装 毛巾/方巾/浴巾各2条","480","Army blue ；handkerchief 34*35cm；washcloth 34*80cm；bath towel 90*140cm","军蓝；方巾34*35cm","packet","条","home","家居","addr","北京市朝阳区","1");
insert into product values("61","FASOLA bath slippers,anti-skidding","FASOLA浴室拖鞋防滑情侣平底洗澡拖鞋男女室内夏季厚底拖鞋 ","23.90","","","packet","双","home","家居","addr","北京市朝阳区","1");
insert into product values("62","Angel Soft Toilet Paper, 48 Double Rolls, Bath Tissue ","天使柔软的卫生纸,48卷","171.90","Pack of 4 with 12 rolls each","每包12卷,共4包","packet","卷","home","家居","addr","北京市朝阳区","1");
insert into product values("63","LED Desk Lamp Fugetek FT-L798, Exclusive Model with Recessed LEDs","LED 桌灯 Fugetek 英尺-L798 USB 充电端口-乌黑 （黑色）","192","Only Model With Recessed LED Design. Dimmable, USB Charging Port, Touch Panel","可调光,USB 充电端口,触摸屏","packet","个","home","家具","addr","北京市朝阳区","1");
insert into product values("64","Epica Super-Grip Non-Slip Area Rug Pad ","景程超级抓地力防滑地毯垫","110","5m*8m","5m * 8m","packet","条","home","家居","addr","北京市朝阳区","1");

#travel
insert into product values("65","Travis Travel Gear Space Saver Bags","特拉维斯旅行齿轮节省空间袋 ","17.90","14 x 7.2 x 1.3 inches 12 ounces ","14 x 7.2 x 1.3英寸 12盎司","pocket","个","travel","旅行","addr","北京市朝阳区","1");
insert into product values("66","YAMIU Travel Shoe Bags Set of 4 Waterproof Nylon With Zipper For Men & Women ","YAMIU旅行鞋袋","11.88","10.1 x 7.5 x 0.7 inches","10.1 x 7.5 x 0.7 英寸","pocket","个","travel","旅行","addr","北京市朝阳区","1");
insert into product values("67","Zoppen Multi-purpose Rfid Blocking Travel Passport Wallet","Zoppen多功能防射频识别旅行护照钱包","14.99","7.5 x 5.0 x 1.0 inches ( 19 x 12.5 x 2.5 cm )","7.5 x 5.0 x 1.0英寸( 19 x 12.5 x 2.5 厘米 )","pocket","个","travel","旅行","addr","北京市朝阳区","1");
insert into product values("68","Travelon Worldwide Adapter with Dual USB Charger ","带双USB充电器的全球适配器","22.99","2 x 2 x 2.2 inches ","2 x 2 x 2.2英寸","pocket","个","travel","旅行","addr","北京市朝阳区","1");


insert into packet values("1",99,10);
insert into packet values("2",99,10);
insert into packet values("3",99,10);
insert into packet values("5",99,10);
insert into packet values("6",499,50);
insert into packet values("7",299,30);
insert into packet values("8",199,20);
insert into packet values("10",199,20);
insert into packet values("11",399,40);
insert into packet values("12",199,20);
insert into packet values("14",499,50);
insert into packet values("15",999,100);
insert into packet values("16",199,100);
insert into packet values("17",399,40);
insert into packet values("18",499,50);
insert into packet values("19",499,50);
insert into packet values("21",999,100);
insert into packet values("22",499,50);
insert into packet values("23",499,50);
insert into packet values("24",99,10);
insert into packet values("30",999,100);
insert into packet values("33",299,30);
insert into packet values("34",999,100);
insert into packet values("35",299,30);
insert into packet values("36",299,30);
insert into packet values("37",299,30);
insert into packet values("38",999,100);
insert into packet values("39",299,30);
insert into packet values("41",499,50);
insert into packet values("42",99,10);
insert into packet values("45",499,50);
insert into packet values("46",99,10);
insert into packet values("47",99,10);
insert into packet values("48",399,40);
insert into packet values("50",99,10);
insert into packet values("51",299,30);
insert into packet values("52",299,30);
insert into packet values("53",99,10);
insert into packet values("54",199,20);
insert into packet values("55",99,10);
insert into packet values("56",99,10);
insert into packet values("57",199,20);
insert into packet values("58",999,100);
insert into packet values("61",299,30);
insert into packet values("62",499,50);
insert into packet values("63",999,100);
insert into packet values("64",999,100);
insert into packet values("65",99,10);
insert into packet values("66",99,10);
insert into packet values("67",99,10);
insert into packet values("68",99,10);
