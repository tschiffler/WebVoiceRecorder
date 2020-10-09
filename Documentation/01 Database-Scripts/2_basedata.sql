INSERT INTO USERS (USERNAME, PASSWORD, TYPE) VALUES ('admin', AES_ENCRYPT('admin', 'ChangeMeInBasedataAndConfig'), 2);
INSERT INTO USERS (USERNAME, PASSWORD, TYPE) VALUES ('user', AES_ENCRYPT('user', 'ChangeMeInBasedataAndConfig'), 1);
