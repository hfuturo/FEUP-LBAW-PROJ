SET search_path TO lbaw2313;

INSERT INTO "topic" (id, name) VALUES (1,'Technology'); 
INSERT INTO "topic" (id, name) VALUES (2,'Health and Wellness');
INSERT INTO "topic" (id,name) VALUES (3,'Travel'); 
INSERT INTO "topic" (id,name) VALUES (4,'Finance'); 
INSERT INTO "topic" (id,name) VALUES (5,'Education'); 

SELECT setval('topic_id_seq', (SELECT max(id) FROM "topic")); -- para nao dar erro ao inserir deviamos de fazer isto para os ids todos

INSERT INTO "tag" (id,name) VALUES (1,'Quantum Computing'); --1
INSERT INTO "tag" (id,name) VALUES (2,'Google');--2
INSERT INTO "tag" (id,name) VALUES (3,'Apple');--3
INSERT INTO "tag" (id,name) VALUES (4,'MacBook Pro');--4
INSERT INTO "tag" (id,name) VALUES (5,'M1X Chip');--5
INSERT INTO "tag" (id,name) VALUES (6,'Facebook');--6
INSERT INTO "tag" (id,name) VALUES (7,'AI');--7
INSERT INTO "tag" (id,name) VALUES (8,'SpaceX');--8
INSERT INTO "tag" (id,name) VALUES (9,'Starship');--9
INSERT INTO "tag" (id,name) VALUES (10,'Microsoft');--10
INSERT INTO "tag" (id,name) VALUES (11,'Augmented Reality');--11
INSERT INTO "tag" (id,name) VALUES (12,'Tesla');--12
INSERT INTO "tag" (id,name) VALUES (13,'Electric Vehicles');--13
INSERT INTO "tag" (id,name) VALUES (14,'Amazon');--14
INSERT INTO "tag" (id,name) VALUES (15,'IBM');--15
INSERT INTO "tag" (id,name) VALUES (16,'Privacy');--16
INSERT INTO "tag" (id,name) VALUES (17,'Intel');--17
INSERT INTO "tag" (id,name) VALUES (18,'High-Performance Computing');--18
INSERT INTO "tag" (id,name) VALUES (19,'Samsung');--19
INSERT INTO "tag" (id,name) VALUES (20,'Tech Expo');--20
INSERT INTO "tag" (id,name) VALUES (21,'Starlink');--21
INSERT INTO "tag" (id,name) VALUES (22,'Drone Delivery');--22
INSERT INTO "tag" (id,name) VALUES (23,'Sustainability');--23
INSERT INTO "tag" (id,name) VALUES (24,'iOS');--24
INSERT INTO "tag" (id,name) VALUES (25,'Health-Tech');--25
INSERT INTO "tag" (id,name) VALUES (26,'Health'); --26
INSERT INTO "tag" (id,name) VALUES (27,'Meditation'); --27
INSERT INTO "tag" (id,name) VALUES (28,'Mental Health'); --28
INSERT INTO "tag" (id,name) VALUES (29,'Nutrition'); --29
INSERT INTO "tag" (id,name) VALUES (30,'Yoga'); --30
INSERT INTO "tag" (id,name) VALUES (31,'Herbal Medicine'); --31
INSERT INTO "tag" (id,name) VALUES (32,'Pain Management'); --32
INSERT INTO "tag" (id,name) VALUES (33,'Plant-Based Diet'); --33
INSERT INTO "tag" (id,name) VALUES (34,'Cardiovascular Health'); --34
INSERT INTO "tag" (id,name) VALUES (35,'Iceland'); --35
INSERT INTO "tag" (id,name) VALUES (36,'Nature'); --36
INSERT INTO "tag" (id,name) VALUES (37,'Rome'); --37
INSERT INTO "tag" (id,name) VALUES (38,'History'); --38
INSERT INTO "tag" (id,name) VALUES (39,'Greece'); --39
INSERT INTO "tag" (id,name) VALUES (40,'IslandLife'); --40
INSERT INTO "tag" (id,name) VALUES (41,'StockMarket'); --41
INSERT INTO "tag" (id,name) VALUES (42,'Energy'); --42
INSERT INTO "tag" (id,name) VALUES (43,'Cryptocurrency'); --43
INSERT INTO "tag" (id,name) VALUES (44,'Bitcoin'); --44

SELECT setval('tag_id_seq', (SELECT max(id) FROM "tag")); -- para nao dar erro ao inserir deviamos de fazer isto para os ids todos

INSERT INTO "authenticated_user" (id,name, email, password, type) VALUES (1, 'John Doe', 'john.doe@gmail.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'admin');
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (2,'Jane Smith', 'jane_smith@yahoo.com', 'Smith123', 'moderator' , 1);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (3,'Sarah Williams', 'sarahwilliams@outlook.com', 'Will@ms1', 'moderator', 2);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (4,'Michael Johnson', 'michael_johnson@hotmail.com', 'J0hnson!', 'moderator', 3);--TEC
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (5,'Robert Brown', 'robert.brown@live.com', 'Br0wnBob', 'moderator', 4);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (6,'Emily Jones', 'emily_jones@icloud.com', 'J0n3m!ly', 'moderator', 5);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (7,'William Davis', 'williamdavis@protonmail.com', 'Dav1sW!ll',  'moderator' , 1); --followOrg
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (8,'Jessica Miller', 'jess.miller@inbox.com', 'J3ss1c@!',  'moderator' , 2);--HE
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (9,'David Wilson', 'davidwilson@mail.com', 'W!ls0nD@v',  'moderator' , 3);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (10,'Ashley Taylor', 'ash.taylor@zoho.com', 'T@yl0rAsh',  'moderator' , 4);
INSERT INTO "authenticated_user" (id,name, email, password, type, id_topic) VALUES (11,'James Anderson', 'james_anderson@yandex.com', 'And3r$0n',  'moderator' , 5);

INSERT INTO "authenticated_user" (id,name, email, password) VALUES (12,'Grace Foster', 'grace_foster@protonmail.com', 'F0st3rGr@'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (13,'Levi Cole', 'levi_cole@zoho.com', 'C0l3L3v'); --HE
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (14,'Hannah Marshall', 'hannah_marshall@yandex.com', 'M@r$h@llH@'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (15,'Aaron Fox', 'aaron_fox@rediffmail.com', 'F0x@r0n'); --he-c
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (16,'Audrey Woods', 'audrey_woods@gmail.com', 'W00ds@ud'); --TU
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (17,'Connor Fisher', 'connor_fisher@yahoo.com', 'F!$h3rC0n'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (18,'Bella Peterson', 'bella_peterson@hotmail.com', 'P3t3rs0nB');--tec-c --TEC member
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (19,'Grayson Reed', 'grayson_reed@outlook.com', 'R33dGr@y');--TEC --TEC leader
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (20,'Layla Griffin', 'layla_griffin@live.com', 'Gr1ff1nL@');--HE
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (21,'Ruby West', 'ruby_west@icloud.com', 'W3$tRb');--FI

INSERT INTO "authenticated_user" (id,name, email, password) VALUES (22,'Leo Hayes', 'leo_hayes@protonmail.com', 'H@y3sL30');--TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (23,'Violet Cole', 'violet_cole@zoho.com', 'C0l3Vi0'); -- TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (24,'Jeremiah Russell', 'jeremiah_russell@yandex.com', 'Ru$$3llJ3r'); -- member
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (25,'Madison Silva', 'madison_silva@rediffmail.com', 'S!lv@Mad');--tec-c --HE member
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (26,'Hudson Stone', 'hudson_stone@gmail.com', 'St0n3Hu$'); --TU
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (27,'Skylar Hawkins', 'skylar_hawkins@yahoo.com', 'H@wk!n$Sky'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (28,'Penelope Kennedy', 'penelope_kennedy@hotmail.com', 'K3nn3dyP3'); --he-c
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (29,'Easton Cole', 'easton_cole@outlook.com', 'C0l3E@st'); --report
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (30,'Savannah Lane', 'savannah_lane@live.com', 'L@n3S@v');--TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (31,'Nicholas Reid', 'nicholas_reid@icloud.com', 'R31dN!c'); --FI

INSERT INTO "authenticated_user" (id,name, email, password) VALUES (32,'Claire Foster', 'claire_foster@protonmail.com', 'F0st3rCl@');--tec-c followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (33,'Maxwell Gray', 'maxwell_gray@zoho.com', 'Gr@yM@x');--tec-c --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (34,'Aurora Fox', 'aurora_fox@yandex.com', 'F0x@ur0'); --asking
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (35,'Austin Woods', 'austin_woods@rediffmail.com', 'W00d$@u');-- TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (36,'Brianna Hart', 'brianna_hart@gmail.com', 'H@rtBr1'); --HE
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (37,'Eliana Meyer', 'eliana_meyer@yahoo.com', 'M3y3rEl1'); --tu-c
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (38,'Adam Bishop', 'adam_bishop@hotmail.com', 'B!$h0pAd'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (39,'Mariah Andrews', 'mariah_andrews@outlook.com', 'Andr3w$M');
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (40,'Owen Snyder', 'owen_snyder@live.com', 'Snyd3r0w'); --asking
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (41,'Josephine Curtis', 'josephine_curtis@icloud.com', 'Curt!sJ0');

INSERT INTO "authenticated_user" (id,name, email, password) VALUES (42,'Eliana Black', 'eliana_black@protonmail.com', 'Bl@ck3l1');--TEC followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (43,'Micah Harvey', 'micah_harvey@zoho.com', 'H@rv3yMi'); --TU --tu-c leader
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (44,'Natalie Day', 'natalie_day@yandex.com', 'D@yN@t'); --FI
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (45,'Adrian Stone', 'adrian_stone@rediffmail.com', 'St0n3Adr'); --HE
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (46,'Liam Johnson', 'liam.j22@gmail.com', 'J0hnL!am'); -- asking
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (47,'Olivia Garcia', 'olivia_89@yahoo.com', 'G@rCi@89'); --TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (48,'Noah Williams', 'williamsnoah44@hotmail.com', 'W1ll!4ms'); --tec-C --TEC invited
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (49,'Emma Smith', 'emma.smith93@outlook.com', 'Sm!th@93'); -- asking
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (50,'Oliver Brown', 'brown.oliver22@live.com', 'Br0wN22!'); --followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (51,'Ava Wilson', 'wilson.ava99@icloud.com', 'W!l$0n99');--TEC followOrg

INSERT INTO "authenticated_user" (id,name, email, password) VALUES (52,'Elijah Taylor', 'etaylor56@protonmail.com', '3T@yl0r56'); --followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (53,'Charlotte Lee', 'c.lee_77@zoho.com', 'Ch@rl0tt77'); --he-c
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (54,'Mason Clark', 'masonclark_x@yandex.com', 'Cl@rkMx12');--followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (55,'Amelia Hall', 'a.hall_45@rediffmail.com', 'H@ll!am45');--TEC
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (56,'Ethan Young', 'young_ethan78@gmail.com', 'Y0ung78!');--followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (57,'Isabella White', 'isabella_white_66@yahoo.com', 'Wh!t3Bella');--HE
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (58,'James Martin', 'james.martin_91@hotmail.com', 'J@m3sM91');--followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (59,'Sophia Garcia', 'sophia_21@outlook.com', 'G@rc!@21');--followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (60,'Benjamin Adams', 'b.adams33@live.com', 'Adam$33!'); --followOrg
INSERT INTO "authenticated_user" (id,name, email, password) VALUES (61,'Mia Wilson', 'miaw_67@icloud.com', 'M!@Wil67'); --followOrg

SELECT setval('authenticated_user_id_seq', (SELECT max(id) FROM "authenticated_user")); -- para nao dar erro ao inserir deviamos de fazer isto para os ids todos

INSERT INTO "organization" (id, name, bio) VALUES (1, 'TechWord', 'The latest news in the world of technology, engines and science');

INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 7);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 32);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 42);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 51);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 52);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (1, 49);

INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (19, 1, 'leader');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (18 ,1, 'member');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (24 ,1, 'member');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (34 ,1, 'asking');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (40 ,1, 'asking');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (48 ,1, 'invited');

INSERT INTO "organization" (id,name, bio) VALUES (2,'TNT', 'It’s our job to #GoThere & tell the most difficult stories.');

SELECT setval('organization_id_seq', (SELECT max(id) FROM "organization"));

INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 54);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 56);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 58);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 59);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 60);
INSERT INTO "follow_organization" (id_organization, id_following) VALUES (2, 61);

INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (43, 2, 'leader');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (25 ,2, 'member');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (8 ,2, 'member');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (49 ,2, 'asking');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (46 ,2, 'asking');
INSERT INTO "membership_status" (id_user, id_organization, member_type) VALUES (48 ,2, 'invited');


INSERT INTO "follow_tag" (id_tag, id_following) VALUES (1, 32);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (1, 48);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (3, 31);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (3, 51);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (7, 30);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (7, 35);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (28, 8);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (28, 13);
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (44, 23); 
INSERT INTO "follow_tag" (id_tag, id_following) VALUES (37, 60);

INSERT INTO "follow_topic" (id_topic, id_following) VALUES (1, 27);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (1, 33);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (1, 12);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (2, 61);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (2, 10);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (2, 53);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (3, 37);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (3, 43);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (3, 60);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (4, 54);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (4, 52);
INSERT INTO "follow_topic" (id_topic, id_following) VALUES (4, 29);


INSERT INTO "follow_user" (id_follower, id_following) VALUES (5, 33);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (37, 18);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (43, 3);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (6, 30);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (10, 57);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (44, 45);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (31, 28);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (25, 1);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (18, 11);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (21, 13);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (27, 49);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (8, 41);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (36, 17);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (54, 58);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (14, 59);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (55, 7);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (24, 46);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (56, 23);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (40, 20);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (52, 12);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (9, 16);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (29, 32);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (22, 50);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (39, 26);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (42, 4);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (60, 35);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (48, 53);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (38, 19);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (47, 2);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (34, 10);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (51, 15);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (45, 36);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (28, 27);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (1, 9);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (13, 55);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (3, 42);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (30, 6);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (17, 54);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (58, 14);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (7, 38);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (46, 24);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (23, 56);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (20, 40);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (12, 52);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (16, 8);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (32, 29);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (50, 22);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (26, 39);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (4, 59);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (35, 60);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (53, 48);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (19, 37);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (2, 47);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (11, 34);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (15, 51);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (36, 45);
INSERT INTO "follow_user" (id_follower, id_following) VALUES (27, 28);



-- 1 TEC

INSERT INTO "content" (id, content, date, id_author) VALUES (1,'Google shocked the world today with the announcement of a major leap in quantum computing technology. The company revealed a new quantum processor that promises to revolutionize the capabilities of computation. With unprecedented processing power and speed, this breakthrough is set to pave the way for solving complex problems in various fields. Experts anticipate significant transformations in industries such as cryptography, pharmaceuticals, and materials science', TO_TIMESTAMP('21/01/2023 09:00:00', 'DD/MM/YYYY HH24:MI:SS'), 27);
INSERT INTO "news_item" (id, id_topic, title) VALUES (1, 1, 'Google Unveils Groundbreaking Quantum Computing Breakthrough');

INSERT INTO "content" (id,content, date, id_author) VALUES (2,'Exciting news! Google`s quantum leap will reshape technology landscapes. Implications for cybersecurity could be profound', TO_TIMESTAMP('21/01/2023 09:15:00', 'DD/MM/YYYY HH24:MI:SS'), 48);
INSERT INTO "comment" (id, id_news) VALUES (2, 1);

INSERT INTO "content" (id,content, date, id_author) VALUES (3,'Impressive strides in quantum computing by Google! Anticipating groundbreaking applications in pharmaceutical research',  TO_TIMESTAMP('21/01/2023 10:30:00', 'DD/MM/YYYY HH24:MI:SS'), 18);
INSERT INTO "comment" (id, id_news) VALUES (3, 1);

INSERT INTO "content" (id,content, date, id_author) VALUES (4,'Revolutionizing computation! Google`s new quantum processor could redefine material science research capabilities', TO_TIMESTAMP('21/01/2023 11:45:00', 'DD/MM/YYYY HH24:MI:SS'), 33);
INSERT INTO "comment" (id, id_news) VALUES (4, 1);

INSERT INTO "content" (id,content, date, id_author) VALUES (5,'Google`s breakthrough in quantum computing is a significant step forward in the realm of cryptography. An era of secure communication beckons',TO_TIMESTAMP( '21/01/2023 13:00:00', 'DD/MM/YYYY HH24:MI:SS'), 25);
INSERT INTO "comment" (id, id_news) VALUES (5, 1);

INSERT INTO "content" (id,content, date, id_author) VALUES (6,'Today marks a historic moment as Google unveils its unprecedented quantum computing power. The future of problem-solving seems brighter than ever!', TO_TIMESTAMP('21/01/2023 14:06:00', 'DD/MM/YYYY HH24:MI:SS'), 32);
INSERT INTO "comment" (id, id_news) VALUES (6, 1);

INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (1,1);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (1,2);


-- 2 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (7,'Apple has officially launched its highly anticipated next-generation MacBook Pro, equipped with the powerful M1X chip. The new device boasts remarkable performance upgrades, increased battery life, and enhanced graphic capabilities. With a sleek design and advanced features, this latest release is expected to set a new standard for professional laptops. Technology enthusiasts and professionals are eagerly awaiting the opportunity to experience the cutting-edge performance of the new MacBook Pro.', TO_TIMESTAMP('15/02/2023 15:00:00' ,'DD/MM/YYYY HH24:MI:SS'), 42);
INSERT INTO "news_item" (id, id_topic, title) VALUES (7, 1, 'Apple Launches Next-Generation MacBook Pro with M1X Chip');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (7,3);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (7,4);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (7,5);


-- 3 TEC Link to Org

INSERT INTO "content" (id,content, date, id_author, id_organization) VALUES (8,'In the ongoing battle against misinformation, Facebook has introduced an innovative AI-powered fact-checking system. This advanced technology aims to detect and flag misleading content across the platform, thereby promoting a more reliable and trustworthy online environment. With the integration of this sophisticated tool, Facebook is taking a proactive stance in ensuring the authenticity and accuracy of information shared on its platform, fostering a safer and more credible online community.', TO_TIMESTAMP('07/03/2023 11:45:00', 'DD/MM/YYYY HH24:MI:SS'), 19, 1);
INSERT INTO "news_item" (id, id_topic, title) VALUES (8, 1, 'Facebook Introduces AI-Powered Fact-Checking to Combat Misinformation');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (8,6);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (8,7);


-- 4 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (9,'SpaceX has achieved a monumental milestone as its Starship completed its inaugural orbital test flight. This significant accomplishment marks a major step forward in the company`s mission to facilitate interplanetary travel. With the successful demonstration of the Starship`s capabilities, SpaceX has garnered widespread acclaim for its pioneering efforts in the realm of space exploration. The successful orbital test flight signifies a promising future for the advancement of space travel and exploration', TO_TIMESTAMP('19/03/2023 13:15:00', 'DD/MM/YYYY HH24:MI:SS'), 55);
INSERT INTO "news_item" (id, id_topic, title) VALUES (9, 1, 'SpaceX`s Starship Successfully Completes Its First Orbital Test Flight');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (9,8);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (9,9);

-- 5 TEC Link to Org
INSERT INTO "content" (id,content, date, id_author, id_organization) VALUES (10,'Microsoft has unveiled the latest iteration of its augmented reality headset, the Hololens 3. Packed with advanced features and improved spatial mapping capabilities, the Hololens 3 promises a more immersive and interactive augmented reality experience. This cutting-edge technology is poised to transform the way users engage with digital content, opening up new possibilities for applications in industries such as healthcare, education, and engineering. Enthusiasts are eagerly anticipating the release of this groundbreaking device.', TO_TIMESTAMP('15/04/2023 14:45:00', 'DD/MM/YYYY HH24:MI:SS'), 18, 1);
INSERT INTO "news_item" (id, id_topic, title) VALUES (10, 1, 'Microsoft Unveils New Hololens 3 with Enhanced Augmented Reality Features');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (10,10);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (10,11);

-- 6 TEC

INSERT INTO "content" (id,content, date, edit_date, id_author) VALUES (11,'Tesla has announced a significant breakthrough in electric vehicle battery technology, showcasing a revolutionary battery cell that promises an extended range and enhanced performance. This innovation represents a major stride in the pursuit of sustainable transportation, as it addresses critical concerns regarding battery life and charging efficiency. With this advancement, Tesla aims to solidify its position as a frontrunner in the electric vehicle industry, fostering a greener and more eco-friendly approach to mobility.', TO_TIMESTAMP('03/05/2023 15:30:00', 'DD/MM/YYYY HH24:MI:SS'), TO_TIMESTAMP('03/05/2023 16:30:00', 'DD/MM/YYYY HH24:MI:SS') ,33);
INSERT INTO "news_item" (id, id_topic, title) VALUES (11, 1, 'Tesla Announces Breakthrough in Electric Vehicle Battery Technology');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (11,12);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (11,13);

-- 7 TEC
INSERT INTO "content" (id,content, date, id_author) VALUES (12,'Amazon has introduced a groundbreaking AI-powered personal assistant, redefining the concept of home automation. This innovative device boasts advanced capabilities, including seamless integration with various smart home systems and enhanced natural language processing. With its intuitive interface and comprehensive functionalities, the AI-powered personal assistant aims to streamline daily tasks and elevate the overall home automation experience. Tech enthusiasts and homeowners are eagerly anticipating the transformative potential of this cutting-edge device.', TO_TIMESTAMP('20/05/2023 16:15:00', 'DD/MM/YYYY HH24:MI:SS'), 4);
INSERT INTO "news_item" (id, id_topic, title) VALUES (12, 1, 'Amazon`s New AI-Powered Personal Assistant Redefines Home Automation');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (12,14);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (12,7);

-- 8 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (13,'IBM has launched an innovative quantum computing service, aiming to accelerate scientific research and discovery. This cloud-based service provides researchers and developers with access to IBM`s advanced quantum computing capabilities, enabling them to tackle complex computational problems with unprecedented efficiency. By democratizing access to quantum computing, IBM is fostering a collaborative environment for scientific innovation, opening up new possibilities for breakthroughs in various fields, including chemistry, physics, and artificial intelligence.', TO_TIMESTAMP('29/05/2023 17:00:00', 'DD/MM/YYYY HH24:MI:SS'), 48);
INSERT INTO "news_item" (id, id_topic, title) VALUES (13, 1, 'IBM`s New Quantum Computing Service to Accelerate Scientific Research');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (13,15);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (13,1);


-- 9 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (14,'Google has unveiled a privacy-focused search engine designed to prioritize user data protection and privacy. This new search engine emphasizes encrypted search queries and implements advanced privacy protocols to safeguard user information from unauthorized access and data breaches. With growing concerns regarding online privacy, Google`s initiative represents a significant step toward fostering a more secure and confidential online search experience, resonating with users who prioritize data protection and privacy.', TO_TIMESTAMP('13/06/2023 18:30:00', 'DD/MM/YYYY HH24:MI:SS'), 12);
INSERT INTO "news_item" (id, id_topic, title) VALUES (14, 1, 'Google`s New Privacy-Focused Search Engine Set to Redefine Online Privacy');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (14,2);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (14,16);

-- 10 TEC

INSERT INTO "content" (id,content, date,edit_date, id_author) VALUES (15,'Intel has introduced its next-generation processors, specifically designed for high-performance computing tasks. The new processors boast remarkable improvements in speed, efficiency, and multitasking capabilities, catering to the increasing demands of data-intensive applications and complex computational tasks. With a focus on optimizing performance and energy efficiency, Intel`s latest release is poised to elevate the computing experience for professionals and enthusiasts in fields such as artificial intelligence, data analysis, and scientific research.', TO_TIMESTAMP('16/07/2023 19:45:00', 'DD/MM/YYYY HH24:MI:SS'), TO_TIMESTAMP('17/07/2023 09:13:00' , 'DD/MM/YYYY HH24:MI:SS'),23);
INSERT INTO "news_item" (id, id_topic, title) VALUES (15, 1, 'Intel Introduces Next-Generation Processors for High-Performance Computing');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (15,17);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (15,18);

-- 11 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (16,'Samsung has wowed tech enthusiasts with the introduction of its innovative rollable OLED display technology at the latest tech expo. This cutting-edge display technology offers unprecedented flexibility and versatility, allowing users to adjust the screen size according to their preferences and requirements. With its sleek design and impressive visual quality, Samsung`s rollable OLED display technology is poised to revolutionize the consumer electronics industry, setting a new standard for immersive and adaptable display solutions.', TO_TIMESTAMP('05/07/2023 20:30:00', 'DD/MM/YYYY HH24:MI:SS'), 38);
INSERT INTO "news_item" (id, id_topic, title) VALUES (16, 1, 'Samsung Unveils Innovative Rollable OLED Display Technology at Tech Expo');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (16,19);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (16,20);


-- 12 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (17,'Apple has announced a strategic collaboration with a pioneering AR start-up, signaling its commitment to advancing augmented reality experiences. This collaboration aims to integrate the start-up`s cutting-edge AR technologies with Apple`s devices, fostering a more immersive and interactive user experience. With a focus on enhancing the capabilities of Apple`s ARKit platform, this partnership is expected to introduce innovative AR applications across various industries, including gaming, education, and digital marketing, transforming the way users engage with digital content.', TO_TIMESTAMP('18/07/2023 21:15:00', 'DD/MM/YYYY HH24:MI:SS'), 51);
INSERT INTO "news_item" (id, id_topic, title) VALUES (17, 1, 'Apple Collaborates with AR Start-up for Enhanced Augmented Reality Experiences');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (17,3);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (17,11);

-- 13 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (18,'SpaceX`s Starlink internet service has achieved a groundbreaking milestone by providing global coverage to remote and underserved regions. With its satellite-based internet infrastructure, Starlink has successfully expanded its network to reach even the most isolated areas, bridging the digital divide and enabling reliable internet connectivity for communities worldwide. This achievement marks a significant step forward in SpaceX`s mission to revolutionize global internet accessibility, providing a promising solution for enhancing digital connectivity and fostering global communication.', TO_TIMESTAMP('27/07/2023 22:00:00', 'DD/MM/YYYY HH24:MI:SS'), 14);
INSERT INTO "news_item" (id, id_topic, title) VALUES (18, 1, 'SpaceX`s Starlink Internet Service Achieves Global Coverage Mileston');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (18,8);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (18,21);

-- 14 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (19,'Microsoft has unveiled an AI-powered language translation tool that promises to break down language barriers and facilitate seamless communication across different languages. Leveraging advanced natural language processing algorithms, this tool offers accurate and efficient translation capabilities, enabling users to overcome linguistic challenges and engage in effective cross-cultural communication. With its user-friendly interface and comprehensive language support, Microsoft`s language translation tool is poised to transform global communication dynamics, fostering a more connected and inclusive global community.', TO_TIMESTAMP('11/08/2023 22:45:00', 'DD/MM/YYYY HH24:MI:SS'), 30);
INSERT INTO "news_item" (id, id_topic, title) VALUES (19, 1, 'Microsoft`s AI-Powered Language Translation Tool Breaks Language Barriers');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (19,10);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (19,7);

-- 15 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (20,'Amazon has expanded its drone delivery service to include rural communities, enabling faster and more efficient product deliveries to customers residing in remote areas. This expansion signifies Amazon`s commitment to enhancing its delivery infrastructure and addressing logistical challenges associated with remote locations. With its drone delivery service, Amazon aims to provide timely and reliable delivery options for customers in rural areas, contributing to improved accessibility and convenience for individuals living in geographically isolated regions.', TO_TIMESTAMP('13/04/2023 23:30:00', 'DD/MM/YYYY HH24:MI:SS'), 47);
INSERT INTO "news_item" (id, id_topic, title) VALUES (20, 1, 'Amazon Expands Its Drone Delivery Service to Rural Communities');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (20,10);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (20,22);


-- 16 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (21,'IBM has developed a groundbreaking AI system specifically tailored for predictive maintenance in the manufacturing industry. This sophisticated AI system leverages advanced machine learning algorithms to analyze real-time data and predict potential equipment failures, allowing manufacturers to proactively address maintenance needs and prevent costly downtime. By implementing IBM`s AI-driven predictive maintenance system, manufacturers can optimize operational efficiency, reduce maintenance costs, and enhance overall productivity, establishing a more sustainable and streamlined manufacturing ecosystem.', TO_TIMESTAMP('03/09/2023 23:59:00', 'DD/MM/YYYY HH24:MI:SS'), 35);
INSERT INTO "news_item" (id, id_topic, title) VALUES (21, 1, 'IBM Develops Breakthrough AI System for Predictive Maintenance in Manufacturing');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (21,7);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (21,15);

-- 17 TEC Link to Org

INSERT INTO "content" (id,content, date, id_author, id_organization) VALUES (22,'Google has initiated an open-source sustainability project aimed at promoting environmental conservation and sustainability efforts worldwide. This project encourages collaboration among developers, researchers, and environmental organizations to devise innovative technological solutions for addressing environmental challenges, including climate change, biodiversity loss, and natural resource depletion. By leveraging the collective expertise of a global community, Google`s open-source sustainability project seeks to drive meaningful change and foster a more sustainable approach to technological innovation and development.', TO_TIMESTAMP('16/09/2023 00:30:00', 'DD/MM/YYYY HH24:MI:SS'), 19 , 1);
INSERT INTO "news_item" (id, id_topic, title) VALUES (22, 1, 'Google Launches Open-Source Sustainability Project for Environmental Conservation');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (22,2);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (22,23);

-- 18 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (23,'Apple has rolled out its latest iOS update, featuring enhanced privacy features that offer users greater control over their data and digital footprint. This update includes advanced privacy settings, improved data encryption protocols, and increased transparency regarding data tracking practices. With a renewed emphasis on user privacy and data security, Apple`s latest iOS update reaffirms the company`s commitment to protecting user information and empowering individuals to make informed decisions about their online privacy and digital interactions.', TO_TIMESTAMP('22/09/2023 01:15:00', 'DD/MM/YYYY HH24:MI:SS'), 17);
INSERT INTO "news_item" (id, id_topic, title) VALUES (23, 1, 'Apple`s Latest iOS Update Introduces Enhanced Privacy Features for Users');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (23,3);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (23,24);


-- 19 TEC

INSERT INTO "content" (id,content, date, id_author) VALUES (24,'Microsoft has announced strategic collaborations with prominent healthcare providers, signaling its commitment to advancing health-tech solutions and digital healthcare services. These collaborations aim to integrate Microsoft`s innovative technologies with healthcare providers systems, facilitating the development of advanced health monitoring tools, telemedicine platforms, and data-driven healthcare solutions. With a focus on improving patient care, streamlining healthcare operations, and enhancing medical research, Microsoft`s partnerships are poised to revolutionize the healthcare industry and foster a more patient-centric and efficient healthcare ecosystem.', TO_TIMESTAMP('02/10/2023 02:00:00', 'DD/MM/YYYY HH24:MI:SS'), 22);
INSERT INTO "news_item" (id, id_topic, title) VALUES (24, 1, 'Microsoft Collaborates with Leading Healthcare Providers for Advanced Health-Tech Solutions');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (24,10);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (24,25);



-- 1 HE

INSERT INTO "content" (id,content, date,edit_date, id_author) VALUES (25,'A recent research study conducted by a team of psychologists from the University of California suggests that regular meditation can significantly reduce stress levels. The study, published in the Journal of Wellness Psychology, found that individuals who practiced mindfulness meditation for at least 20 minutes a day experienced a notable decrease in their stress hormone levels. The researchers believe that the practice of mindfulness meditation can be a valuable tool in managing stress-related disorders such as anxiety and depression. These findings have the potential to revolutionize the way we approach mental health and well-being, emphasizing the importance of incorporating meditation into our daily routines for a healthier and more balanced lifestyle.', TO_TIMESTAMP('15/05/2023 09:30:00', 'DD/MM/YYYY HH24:MI:SS'), TO_TIMESTAMP('01/06/2023 12:00:00' , 'DD/MM/YYYY HH24:MI:SS'),24);
INSERT INTO "news_item" (id, id_topic, title) VALUES (25, 2, 'New Study Reveals the Power of Meditation in Lowering Stress Levels');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (25,26);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (25,27);

-- 1.1 comments
INSERT INTO "content" (id,content, date, id_author) VALUES (26,'This is a significant finding! Incorporating meditation into daily life seems like a promising way to alleviate stress and promote overall well-being. Looking forward to more research in this area', TO_TIMESTAMP('16/05/2023 10:37:00', 'DD/MM/YYYY HH24:MI:SS'), 8);
INSERT INTO "comment" (id, id_news) VALUES (26,25);


INSERT INTO "content" (id,content, date, id_author) VALUES (27,'As someone who practices meditation regularly, I can attest to its positive effects on stress reduction. It`s great to see scientific studies backing up what many of us have experienced firsthand. Kudos to the researchers for shedding light on this important aspect of mental health', TO_TIMESTAMP('17/05/2023 11:22:00', 'DD/MM/YYYY HH24:MI:SS'), 53);
INSERT INTO "comment" (id, id_news) VALUES (27,25);

-- 2 HE

INSERT INTO "content" (id,content, date, id_author) VALUES (28,'Laughter has long been known to be the best medicine, and recent research has shed light on the powerful effects of laughter therapy on mental health. A study published in the Journal of Psychosomatic Medicine demonstrated that laughter therapy can improve mood and alleviate symptoms of depression and anxiety. The research suggests that laughter triggers the release of endorphins, the body`s natural feel-good chemicals, which can promote an overall sense of well-being. This discovery underscores the importance of incorporating humor and laughter into therapeutic practices, offering a promising and accessible approach to enhancing mental wellness.', TO_TIMESTAMP('05/07/2023 11:00:00', 'DD/MM/YYYY HH24:MI:SS'), 13);
INSERT INTO "news_item" (id, id_topic, title) VALUES (28, 2, 'The Surprising Benefits of Laughter Therapy for Mental Health');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (28,28);

-- 3 HE

INSERT INTO "content" (id,content, date, id_author) VALUES (29,'The field of nutritional psychiatry has gained significant attention in recent years for its potential impact on mental health treatment. A comprehensive review published in the Journal of Nutritional Neuroscience highlighted the intricate connection between dietary patterns and mental well-being. The findings suggest that a balanced and nutrient-rich diet, including essential vitamins, minerals, and omega-3 fatty acids, can play a crucial role in reducing the risk of developing mental health disorders such as depression and anxiety. This emerging field offers new possibilities for holistic and integrative approaches to mental health care, emphasizing the importance of a healthy diet in promoting overall well-being.', TO_TIMESTAMP('20/04/2023 10:43:00', 'DD/MM/YYYY HH24:MI:SS'), 36);
INSERT INTO "news_item" (id, id_topic, title) VALUES (29, 2, 'The Role of Nutritional Psychiatry in Mental Health Treatment');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (29,28);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (29,29);


-- 4 HE

INSERT INTO "content" (id,content, date, id_author) VALUES (30,'Yoga, an ancient practice known for its physical and mental benefits, has gained recognition for its positive impact on mental health. A recent study published in the Journal of Mind-Body Medicine revealed that regular yoga practice can significantly reduce symptoms of stress and anxiety, while improving overall mood and well-being. The research suggests that the combination of physical postures, breathing techniques, and mindfulness in yoga contributes to the enhancement of the mind-body connection, fostering a sense of inner peace and emotional stability. These findings underscore the therapeutic potential of yoga as a holistic approach to promoting mental wellness and resilience.', TO_TIMESTAMP('10/09/2023 08:29:00', 'DD/MM/YYYY HH24:MI:SS'), 45);
INSERT INTO "news_item" (id, id_topic, title) VALUES (30, 2, 'The Power of Mind-Body Connection: How Yoga Benefits Mental Health');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (30,28);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (30,30);

-- 5 HE 

INSERT INTO "content" (id,content, date, id_author) VALUES (31,'Herbal medicine has been increasingly recognized for its potential in alleviating chronic pain and promoting long-term well-being. A comprehensive meta-analysis, published in the Journal of Integrative Medicine, highlighted the efficacy of various herbal remedies in managing chronic pain conditions, including arthritis, migraines, and neuropathic pain. The study emphasized the anti-inflammatory and analgesic properties of specific herbs, such as turmeric, ginger, and devil`s claw, which have shown promising results in reducing pain and improving overall quality of life. These findings offer new insights into the role of herbal medicine as a complementary and integrative approach to chronic pain management, providing a natural alternative to conventional pharmaceutical intervention.', TO_TIMESTAMP('25/09/2023 12:56:00', 'DD/MM/YYYY HH24:MI:SS'), 20);
INSERT INTO "news_item" (id, id_topic, title) VALUES (31, 2, 'Unveiling the Healing Power of Herbal Medicine in Chronic Pain Management');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (31,31);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (31,32);

-- 6 HE

INSERT INTO "content" (id,content, date, id_author) VALUES (32,'Plant-based diets have garnered increasing attention for their potential cardiovascular health benefits. A comprehensive review published in the Journal of Cardiology and Nutrition highlighted the positive impact of plant-based nutrition in reducing the risk of cardiovascular diseases, including hypertension, atherosclerosis, and coronary artery disease. The study emphasized the rich array of nutrients, antioxidants, and fiber found in plant-based foods, which contribute to improved cholesterol levels, blood pressure regulation, and overall heart health. These findings underscore the significance of incorporating more plant-based options into dietary practices, offering a sustainable and heart-healthy approach to nutrition and wellness.', TO_TIMESTAMP('12/10/2023 10:38:00', 'DD/MM/YYYY HH24:MI:SS'), 57);
INSERT INTO "news_item" (id, id_topic, title) VALUES (32, 2, 'The Growing Popularity of Plant-Based Diets for Cardiovascular Health');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (32,33);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (32,34);


-- Comments

INSERT INTO "content" (id,content, date, id_author) VALUES (33,'It`s encouraging to see the increasing recognition of the benefits of a plant-based diet on cardiovascular health. With the rise in lifestyle-related diseases, promoting such dietary changes could have a significant impact on public health and well-being', TO_TIMESTAMP('13/10/2023 10:37:00', 'DD/MM/YYYY HH24:MI:SS'), 28);
INSERT INTO "comment" (id, id_news) VALUES (33,32);

INSERT INTO "content" (id,content, date, id_author) VALUES (34,'This research aligns with my personal experience of adopting a plant-based diet. Not only has it positively impacted my cardiovascular health, but it has also led to overall improvements in energy levels and well-being. I hope this trend continues to gain momentum and awareness among the broader population', TO_TIMESTAMP('14/10/2023 11:13:00', 'DD/MM/YYYY HH24:MI:SS'), 15);
INSERT INTO "comment" (id, id_news) VALUES (34,32);


-- 1 TU

INSERT INTO "content" (id,content, date, id_author) VALUES (35,'Adventurers flock to Iceland to witness its breathtaking landscapes, including cascading waterfalls, vast glaciers, and geothermal hot springs. As the northern lights dance across the sky, tourists embrace the magical ambiance of this Nordic wonderland. With a burgeoning interest in eco-tourism, travelers are drawn to the country`s commitment to sustainability, ensuring that its natural beauty remains preserved for generations to come.', TO_TIMESTAMP('15/03/2023 10:52:00', 'DD/MM/YYYY HH24:MI:SS'), 26);
INSERT INTO "news_item" (id, id_topic, title) VALUES (35, 3, 'Exploring the Enchanting Wilderness of Iceland');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (35,35);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (35,36);

-- 2 TU

INSERT INTO "content" (id,content, date, id_author , id_organization) VALUES (36,'Rome, the eternal city, continues to captivate travelers with its rich history and cultural treasures. Amidst the iconic Colosseum and the grandeur of the Vatican City, visitors immerse themselves in the essence of a bygone era. From savoring traditional Italian cuisine to strolling through cobblestone alleys, tourists indulge in an authentic Roman experience. The city`s vibrant energy and historical significance make it an unparalleled destination for history enthusiasts and avid explorers.', TO_TIMESTAMP('05/06/2023 14:32:00', 'DD/MM/YYYY HH24:MI:SS'), 43 , 2);
INSERT INTO "news_item" (id, id_topic, title) VALUES (36, 3, 'Unveiling the Charms of Ancient Rome: A Timeless Journey');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (36,37);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (36,38);

-- comments

INSERT INTO "content" (id,content, date, id_author) VALUES (37,'I visited Rome last summer, and it was truly a journey through time. The Colosseum`s grandeur left me in awe!', TO_TIMESTAMP('18/05/2023 17:41:00', 'DD/MM/YYYY HH24:MI:SS'), 37);
INSERT INTO "comment" (id, id_news) VALUES (37,36);

INSERT INTO "content" (id,content, date, id_author) VALUES (38,'The charm of Rome is truly irresistible. From the Vatican`s solemn beauty to the bustling streets, every corner tells a story of the past', TO_TIMESTAMP('03/08/2023 14:47:00', 'DD/MM/YYYY HH24:MI:SS'), 60);
INSERT INTO "comment" (id, id_news) VALUES (38,36);

-- 3 TU

INSERT INTO "content" (id,content, date, id_author) VALUES (39, 'Enthralled by the allure of the Aegean Sea, seafarers embark on a journey through the Greek Isles, exploring the enchanting beauty of Santorini, Mykonos, and Crete. With their whitewashed architecture and azure waters, these islands offer a picturesque escape for those seeking tranquility and cultural immersion. From savoring delectable Mediterranean cuisine to embracing the warmth of Greek hospitality, travelers are left enchanted by the charm of these idyllic destinations.', TO_TIMESTAMP('12/09/2023 13:57:00', 'DD/MM/YYYY HH24:MI:SS'), 16);
INSERT INTO "news_item" (id, id_topic, title) VALUES (39, 3, 'Sailing the Aegean Sea: A Serene Odyssey through Greek Isles');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (39,39);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (39,40);


-- 1 FI

INSERT INTO "content" (id, content, date, id_author) VALUES (40,'Apple Inc. has reached a new milestone in its market valuation, becoming the first American company to exceed the $3 trillion mark. The tech giant`s stock surged following the release of their latest product line, including the highly anticipated iPhone 14 and advancements in their services segment. With robust demand from global markets and a promising outlook for the upcoming quarter, analysts predict continued growth potential for Apple. This achievement reinforces the company`s position as a dominant force in the tech industry, solidifying investor confidence and sparking discussions about its potential impact on the broader market.', TO_TIMESTAMP('19/10/2023 10:22:00', 'DD/MM/YYYY HH24:MI:SS'), 31);
INSERT INTO "news_item" (id, id_topic, title) VALUES (40, 4, 'Apple Surpasses $3 Trillion Market Value, Setting New Record');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (40,3);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (40,41);

-- 2 F1

INSERT INTO "content" (id, content, date, id_author) VALUES (41, 'The cryptocurrency market experienced a turbulent phase today as Bitcoin, the leading digital currency, saw a significant drop of 12% within a few hours. This sudden downturn triggered a ripple effect across other major altcoins, leading to a general market correction. Analysts attribute this downturn to profit-taking, regulatory concerns, and increased scrutiny from global financial authorities. However, some experts remain optimistic, citing the ongoing institutional adoption and the growing acceptance of blockchain technology. Investors are advised to closely monitor market trends and regulatory developments in the coming days to make informed decisions about their cryptocurrency portfolios.', TO_TIMESTAMP('20/10/2023 18:39:00', 'DD/MM/YYYY HH24:MI:SS'), 44);
INSERT INTO "news_item" (id, id_topic, title) VALUES (41, 4, 'Cryptocurrency Market Fluctuates as Bitcoin Price Drops by 12%');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (41,23);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (41,42);

-- report comment and user

INSERT INTO "content" (id, content, date, id_author) VALUES (42,'Bitcoin`s crash was long overdue. Cryptos are just a scam anyway. People investing in this garbage deserve to lose their money. Go fuck yourself!', TO_TIMESTAMP('20/10/2023 22:43:00', 'DD/MM/YYYY HH24:MI:SS'), 41);
INSERT INTO "comment" (id, id_news) VALUES (42,41);

INSERT INTO "report" (reason, date, type, id_reporter, id_content) VALUES ('Contains insults or inappropriate language',TO_TIMESTAMP('20/10/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'),'content',31,42);
INSERT INTO "report" (reason, date, type, id_reporter, id_content) VALUES ('Contains insults or inappropriate language',TO_TIMESTAMP('21/10/2023 23:39:00', 'DD/MM/YYYY HH24:MI:SS'),'content',23,42);

INSERT INTO "report" (reason, date, type, id_reporter, id_user) VALUES ('Troll/abusive writer', TO_TIMESTAMP('20/10/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'),'user',31,41);
INSERT INTO "report" (reason, date, type, id_reporter, id_user) VALUES ('Troll/abusive writer',TO_TIMESTAMP('21/10/2023 23:42:00', 'DD/MM/YYYY HH24:MI:SS'),'user',23,41);



-- 3 FI Fora do topico


INSERT INTO "content" (id, content, date, id_author) VALUES (43,'In a significant stride toward a greener future, scientists have unveiled a groundbreaking solar technology that promises to revolutionize the renewable energy sector. The new innovation, based on advanced photovoltaic cells, has demonstrated a remarkable 30% increase in energy conversion efficiency, surpassing previous industry benchmarks. This leap in efficiency could potentially drive down the costs of solar power generation and accelerate the transition to sustainable energy sources worldwide. With its potential implications for mitigating climate change and reducing reliance on fossil fuels, the development has garnered attention from both environmentalists and industry leaders, igniting hope for a more sustainable and eco-friendly energy landscape.', TO_TIMESTAMP('25/09/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'), 21);
INSERT INTO "news_item" (id, id_topic, title) VALUES (43, 4, 'Breakthrough in Sustainable Energy: New Solar Technology Maximizes Efficiency');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (43,43);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (43,44);

INSERT INTO "content" (id, content, date, id_author) VALUES (44,'In a significant stride toward a greener future, scientists have unveiled a groundbreaking solar technology that promises to revolutionize the renewable energy sector. The new innovation, based on advanced photovoltaic cells, has demonstrated a remarkable 30% increase in energy conversion efficiency, surpassing previous industry benchmarks. This leap in efficiency could potentially drive down the costs of solar power generation and accelerate the transition to sustainable energy sources worldwide. With its potential implications for mitigating climate change and reducing reliance on fossil fuels, the development has garnered attention from both environmentalists and industry leaders, igniting hope for a more sustainable and eco-friendly energy landscape.', TO_TIMESTAMP('25/09/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'), 9);
INSERT INTO "news_item" (id, id_topic, title) VALUES (44, 4, 'Breakthrough in Sustainable Energy: New Solar Technology Maximizes Efficiency');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (44,43);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (44,44);

INSERT INTO "content" (id, content, date, id_author) VALUES (45,'In a significant stride toward a greener future, scientists have unveiled a groundbreaking solar technology that promises to revolutionize the renewable energy sector. The new innovation, based on advanced photovoltaic cells, has demonstrated a remarkable 30% increase in energy conversion efficiency, surpassing previous industry benchmarks. This leap in efficiency could potentially drive down the costs of solar power generation and accelerate the transition to sustainable energy sources worldwide. With its potential implications for mitigating climate change and reducing reliance on fossil fuels, the development has garnered attention from both environmentalists and industry leaders, igniting hope for a more sustainable and eco-friendly energy landscape.', TO_TIMESTAMP('25/09/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'), 9);
INSERT INTO "news_item" (id, id_topic, title) VALUES (45, 4, 'Breakthrough in Sustainable Energy: New Solar Technology Maximizes Efficiency');
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (45,43);
INSERT INTO "news_tag" (id_news_item, id_tag) VALUES (45,44);

INSERT INTO "report" (reason, date, type, id_reporter, id_content) VALUES ('Off Topic', TO_TIMESTAMP('25/09/2023 09:39:00', 'DD/MM/YYYY HH24:MI:SS'),'content',29,42);

SELECT setval('content_id_seq', (SELECT max(id) FROM "content"));

--suggest_topic

INSERT INTO "suggested_topic" (name, justification, id_user) VALUES ('Sport', 'A sports topic is a valuable addition as it can attract new visitors to the site, thereby enhancing its overall appeal and completeness.',39);

-- votes positives
INSERT INTO "vote" (id_user,id_content,vote) VALUES (18,1,1); --27 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (33,1,1); --27 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (48,1,1); --27 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (42,2,1); --48 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (30,5,1); --25 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (38,6,1); --32 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (40,8,1); --19 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (30,12,1); --4 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (35,12,1); --4 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (19,21,1); --35 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (18,21,1); --35 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (19,18,1); --14 
iNSERT INTO "vote" (id_user,id_content,vote) VALUES (38,18,1); --14 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (31,23,1); --17 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (51,23,1); --17 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (12,28,1); --13 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (39,28,1); --13 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (37,36,1); --43 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (43,36,1); --43 
INSERT INTO "vote" (id_user,id_content,vote) VALUES (53,38,1); --60 

-- votes negatives

INSERT INTO "vote" (id_user,id_content,vote) VALUES (60,32,-1); --57
INSERT INTO "vote" (id_user,id_content,vote) VALUES (54,40,-1); --31
INSERT INTO "vote" (id_user,id_content,vote) VALUES (14,41,-1); --44
INSERT INTO "vote" (id_user,id_content,vote) VALUES (22,41,-1); --44

INSERT INTO "vote" (id_user,id_content,vote) VALUES (1,42,-1);  --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (9,42,-1);  --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (23,42,-1); --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (31,42,-1); --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (44,42,-1); --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (46,42,-1); --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (49,42,-1); --41
INSERT INTO "vote" (id_user,id_content,vote) VALUES (57,42,-1); --41