DROP SCHEMA lbaw2313 CASCADE;
CREATE SCHEMA lbaw2313;

SET search_path TO lbaw2313;

DROP TABLE IF EXISTS "suggested_topic";
DROP TABLE IF EXISTS "news_tag";
DROP TABLE IF EXISTS "vote";
DROP TABLE IF EXISTS "membership_status";
DROP TABLE IF EXISTS "notified";
DROP TABLE IF EXISTS "notification";
DROP TABLE IF EXISTS "report";
DROP TABLE IF EXISTS "follow_topic";
DROP TABLE IF EXISTS "follow_tag";
DROP TABLE IF EXISTS "follow_organization";
DROP TABLE IF EXISTS "follow_user";
DROP TABLE IF EXISTS "comment";
DROP TABLE IF EXISTS "news_item";
DROP TABLE IF EXISTS "content";
DROP TABLE IF EXISTS "organization";
DROP TABLE IF EXISTS "authenticated_user";
DROP TABLE IF EXISTS "tag";
DROP TABLE IF EXISTS "topic";

DROP TYPE  IF EXISTS "member_type";
DROP TYPE  IF EXISTS "notification_type";
DROP TYPE  IF EXISTS "report_type";
DROP TYPE  IF EXISTS "user_type";

CREATE TABLE "topic"
(
  id SERIAL,
  name TEXT UNIQUE NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE "tag"
(
  id SERIAL,
  name TEXT UNIQUE NOT NULL,
  PRIMARY KEY(id)
);

CREATE TYPE user_type AS ENUM ('authenticated', 'moderator', 'admin');

CREATE TABLE "authenticated_user"
(
  id SERIAL,
  name TEXT NOT NULL,
  email TEXT NOT NULL CONSTRAINT email_user_uk UNIQUE,
  password TEXT NOT NULL,
  image TEXT NOT NULL DEFAULT 'pfp_default.jpeg',
  reputation INTEGER NOT NULL DEFAULT 0,
  bio TEXT NOT NULL DEFAULT '',
  blocked BOOLEAN NOT NULL DEFAULT false,
  blocked_appeal TEXT NOT NULL DEFAULT '',
  appeal_rejected BOOLEAN NOT NULL DEFAULT false,
  type user_type NOT NULL DEFAULT 'authenticated'::user_type,
  remember_token VARCHAR,
  recover_password_tries INTEGER DEFAULT NULL,
  recover_password_code INTEGER DEFAULT NULL,
  PRIMARY KEY(id),
  -- data specific to each authenticated_user type
  id_topic INTEGER REFERENCES "topic" (id) ON UPDATE CASCADE ON DELETE SET NULL, -- moderator
  CHECK (
    (type = 'moderator'::user_type AND id_topic IS NOT NULL) OR
    (id_topic IS NULL)
  )
);

CREATE TABLE "organization"
(
  id SERIAL,
  name TEXT NOT NULL UNIQUE,
  bio TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE "content"
(
  id SERIAL,
  content TEXT NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT now() ,
  edit_date TIMESTAMP DEFAULT NULL,
  id_author INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
  id_organization INTEGER REFERENCES "organization" (id) ON UPDATE CASCADE ON DELETE SET NULL,
  PRIMARY KEY(id),
  CHECK (
    (edit_date IS NOT NULL and edit_date>=date AND edit_date<=now()) OR
    (edit_date IS NULL)
  ),
  CHECK (date<=now())
);

CREATE TABLE "news_item"
(
  id INTEGER REFERENCES "content" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_topic INTEGER NOT NULL REFERENCES "topic" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  title TEXT NOT NULL,
  image TEXT,
  PRIMARY KEY(id)
);

CREATE TABLE "comment"
(
  id INTEGER REFERENCES "content" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_news INTEGER NOT NULL REFERENCES "news_item" (id) ON UPDATE CASCADE ON DELETE RESTRICT,
  PRIMARY KEY(id)
);

CREATE TABLE "follow_user"
(
  id_follower INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_following INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  CHECK (id_follower != id_following),
  PRIMARY KEY(id_follower,id_following)
);

CREATE TABLE "follow_organization"
(
  id_organization INTEGER REFERENCES "organization" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_following INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY(id_organization,id_following)
);

CREATE TABLE "follow_tag"
(
  id_tag INTEGER REFERENCES "tag" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_following INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY(id_tag,id_following)
);

CREATE TABLE "follow_topic"
(
  id_topic INTEGER REFERENCES "topic" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_following INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY(id_topic,id_following)
);

CREATE TYPE report_type AS ENUM ('tag', 'content', 'user');

CREATE TABLE "report"
(
  id SERIAL,
  reason TEXT NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT now() CHECK (date<=now()),
  type report_type NOT NULL,
  id_reporter INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
  PRIMARY KEY(id),
  -- data specific to each report type
  id_tag INTEGER REFERENCES "tag" (id) ON UPDATE CASCADE ON DELETE CASCADE,                -- tag_report
  id_content INTEGER REFERENCES "content" (id) ON UPDATE CASCADE ON DELETE CASCADE,        -- content_report
  id_user INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE, -- user_report
  CHECK (
    (type='tag'::report_type     AND id_tag IS NOT NULL AND id_content IS     NULL AND id_user IS     NULL) OR
    (type='content'::report_type AND id_tag IS     NULL AND id_content IS NOT NULL AND id_user IS     NULL) OR
    (type='user'::report_type    AND id_tag IS     NULL AND id_content IS     NULL AND id_user IS NOT NULL)
  )
);

CREATE TYPE notification_type AS ENUM ('organization', 'content', 'follow', 'vote');
CREATE TYPE member_type AS ENUM ('asking', 'invited', 'member','leader');

CREATE TABLE "notification"
(
  id SERIAL PRIMARY KEY,
  type notification_type NOT NULL,

  -- data specific to each notification type
  id_organization INTEGER REFERENCES "organization" (id) ON UPDATE CASCADE ON DELETE CASCADE, -- organization_notification
  membership_status member_type,                                            -- organization_notification

  id_content INTEGER REFERENCES "content" (id) ON UPDATE CASCADE ON DELETE CASCADE,           -- content_notification

  id_user INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,   -- follow_notification

  CHECK (
    (type='organization'::notification_type AND id_organization IS NOT NULL AND id_content is     NULL AND id_user IS     NULL AND membership_status IS NOT NULL) OR
    (type='content'::notification_type      AND id_organization IS     NULL AND id_content is NOT NULL AND id_user IS     NULL AND membership_status IS     NULL) OR
    (type='follow'::notification_type       AND id_organization IS     NULL AND id_content is     NULL AND id_user IS NOT NULL AND membership_status IS     NULL) OR
    (type='vote'::notification_type         AND id_organization IS     NULL AND id_content IS NOT NULL AND id_user IS NOT NULL AND membership_status IS     NULL)
  )
);

CREATE TABLE "notified"
(
  id_notification INTEGER REFERENCES "notification" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_notified INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  date TIMESTAMP DEFAULT now() CHECK (date<=now()),
  view BOOLEAN NOT NULL DEFAULT false,
  PRIMARY KEY (id_notification, id_notified)
);

CREATE TABLE "membership_status"
(
  id_user INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_organization INTEGER REFERENCES "organization" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  joined_date TIMESTAMP DEFAULT NULL CHECK (joined_date IS NULL OR joined_date<=now()),
  member_type member_type NOT NULL,

  PRIMARY KEY(id_user,id_organization)
);

CREATE TABLE "vote"
(
  id_user INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_content INTEGER REFERENCES "content" (id) ON UPDATE CASCADE ON DELETE RESTRICT,
  vote INTEGER NOT NULL CONSTRAINT like_ck CHECK ((vote=1) or (vote=-1)),
  PRIMARY KEY(id_user,id_content)
);

CREATE TABLE "news_tag"
(
  id_news_item INTEGER REFERENCES "news_item" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_tag INTEGER REFERENCES "tag" (id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY(id_news_item,id_tag)
);

CREATE TABLE "suggested_topic"
(
  id SERIAL PRIMARY KEY,
  name TEXT NOT NULL,
  justification TEXT,
  id_user INTEGER REFERENCES "authenticated_user" (id) ON UPDATE CASCADE ON DELETE CASCADE
);

DROP FUNCTION IF EXISTS update_user_reputation_on_insert_vote() CASCADE;
CREATE FUNCTION update_user_reputation_on_insert_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE authenticated_user
    SET reputation = reputation + New.vote
    WHERE id = (SELECT id_author from content where id=New.id_content);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS insert_vote_reputation ON vote;
CREATE TRIGGER insert_vote_reputation
        AFTER INSERT ON vote
        FOR EACH ROW
        EXECUTE PROCEDURE update_user_reputation_on_insert_vote();


DROP FUNCTION IF EXISTS update_user_reputation_on_update_vote() CASCADE;
CREATE FUNCTION update_user_reputation_on_update_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE authenticated_user
    SET reputation = reputation - old.vote + New.vote
    WHERE id = (SELECT id_author from content where id=Old.id_content);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS update_vote_reputation ON vote;
CREATE TRIGGER update_vote_reputation
        AFTER UPDATE ON vote
        FOR EACH ROW
        EXECUTE PROCEDURE update_user_reputation_on_update_vote();


DROP FUNCTION IF EXISTS update_user_reputation_on_remove_vote() CASCADE;
CREATE FUNCTION update_user_reputation_on_remove_vote() RETURNS TRIGGER AS
$BODY$
BEGIN
	UPDATE authenticated_user
	SET reputation = reputation - old.vote
	WHERE id = (SELECT id_author FROM content WHERE id = old.id_content);
	RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS remove_vote_reputation ON vote;
CREATE TRIGGER remove_vote_reputation
	AFTER DELETE ON vote
	FOR EACH ROW
	EXECUTE PROCEDURE update_user_reputation_on_remove_vote();


DROP FUNCTION IF EXISTS delete_notification() CASCADE;
CREATE FUNCTION delete_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF NOT EXISTS(SELECT id_notification FROM notified WHERE id_notification=old.id_notification)
    THEN
        DELETE FROM notification WHERE id=Old.id_notification;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER view_false_notification
        AFTER DELETE ON notified
        FOR EACH ROW
        EXECUTE PROCEDURE delete_notification();

DROP FUNCTION IF EXISTS add_follow_notification() CASCADE;
CREATE FUNCTION add_follow_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
        IF NOT EXISTS(
            SELECT id
            FROM notification
            WHERE id_user=New.id_follower AND type='follow'
        )
        THEN
            INSERT INTO notification(type,id_user)
            VALUES('follow', New.id_follower);
        END IF;
        INSERT INTO notified(id_notification, id_notified)
            VALUES ((
                SELECT id FROM notification WHERE id_user=New.id_follower AND type='follow'
            ),New.id_following);
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_user_notification
        AFTER INSERT ON follow_user
        FOR EACH ROW
        EXECUTE PROCEDURE add_follow_notification();

DROP FUNCTION IF EXISTS remove_follow_notification() CASCADE;
CREATE FUNCTION remove_follow_notification() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM notified
        WHERE id_notification IN (
            SELECT id FROM notification WHERE id_user = old.id_follower AND type='follow'
        ) AND id_notified = old.id_following;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER unfollow_user_notification
        AFTER DELETE ON follow_user
        FOR EACH ROW
        EXECUTE PROCEDURE remove_follow_notification();

DROP FUNCTION IF EXISTS remove_topic_sugestions_on_creation() CASCADE;
CREATE FUNCTION remove_topic_sugestions_on_creation() RETURNS TRIGGER AS
$BODY$
BEGIN
  DELETE FROM suggested_topic WHERE name = new.name;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS topic_sugestions_cleanup ON topic;
CREATE TRIGGER topic_sugestions_cleanup
  AFTER INSERT ON topic
  FOR EACH ROW
  EXECUTE PROCEDURE remove_topic_sugestions_on_creation();

DROP FUNCTION IF EXISTS block_topic_sugestions_if_already_exists() CASCADE;
CREATE FUNCTION block_topic_sugestions_if_already_exists() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(
        SELECT id FROM topic WHERE new.name = topic.name
    )
    THEN
        RAISE EXCEPTION 'Cannot create sugestion for an existing topic';
    END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS block_topic_sugestions_if_already_exists_trigger ON suggested_topic;
CREATE TRIGGER block_topic_sugestions_if_already_exists_trigger
  BEFORE INSERT ON suggested_topic
  FOR EACH ROW
  EXECUTE PROCEDURE block_topic_sugestions_if_already_exists();

DROP FUNCTION IF EXISTS update_joined_at_if_new_member() CASCADE;
CREATE FUNCTION update_joined_at_if_new_member() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(
        SELECT id_user FROM membership_status WHERE joined_date IS NULL AND id_user=new.id_user AND id_organization=new.id_organization AND (member_type = 'member' OR member_type = 'leader')
    )
    THEN
        UPDATE membership_status SET joined_date=now() WHERE id_user=new.id_user AND id_organization=new.id_organization;
    END IF;
  RETURN new;
END
$BODY$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS update_joined_at ON membership_status;
CREATE TRIGGER update_joined_at
  AFTER UPDATE OR INSERT ON membership_status
  FOR EACH ROW
  EXECUTE PROCEDURE update_joined_at_if_new_member();

DROP FUNCTION IF EXISTS create_new_leader_if_no_one_left() CASCADE;
CREATE FUNCTION create_new_leader_if_no_one_left() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF NOT EXISTS(
      SELECT id_user FROM membership_status WHERE member_type = 'leader' AND id_organization=old.id_organization
  )
  THEN
      UPDATE membership_status SET member_type = 'leader'
      WHERE id_organization = old.id_organization AND joined_date = (
          SELECT MIN(joined_date) FROM membership_status WHERE id_organization=old.id_organization AND joined_date IS NOT NULL
      );
  END IF;
  IF NOT EXISTS(
      SELECT id_user FROM membership_status WHERE member_type = 'leader' AND id_organization=old.id_organization
  )
  THEN
      DELETE FROM organization WHERE id=old.id_organization;
  END IF;


  RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;


DROP TRIGGER IF EXISTS create_new_leader ON membership_status;
CREATE TRIGGER create_new_leader
  AFTER UPDATE OR DELETE ON membership_status
  FOR EACH ROW
  EXECUTE PROCEDURE create_new_leader_if_no_one_left();

CREATE OR REPLACE FUNCTION new_content_topic() 
RETURNS TRIGGER AS $$
DECLARE
    item INTEGER;
    author INTEGER;
BEGIN
    IF NOT EXISTS (
        SELECT id
        FROM notification
        WHERE id_content = NEW.id AND type='content'
    ) THEN
        INSERT INTO notification(type, id_content) VALUES ('content', NEW.id);
    END IF;
    SELECT id FROM notification WHERE id_content = NEW.id AND type='content' INTO item;
    SELECT id_author FROM "content" where id = NEW.id INTO author;
    INSERT INTO notified(id_notification, id_notified)
        SELECT item, id_following 
        FROM follow_topic 
        WHERE id_following <> author AND id_topic = NEW.id_topic;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER new_content_topic_trigger
    AFTER INSERT ON news_item
    FOR EACH ROW
    EXECUTE FUNCTION new_content_topic();

CREATE OR REPLACE FUNCTION notify_author()
RETURNS TRIGGER AS $$
DECLARE
    not_com INTEGER;
    item_author INTEGER;
BEGIN
    IF NOT EXISTS (
        SELECT id
        FROM notification
        WHERE id_content = NEW.id AND type='content'
    ) THEN
        INSERT INTO notification(type, id_content) VALUES ('content', NEW.id);
    END IF;
    SELECT id_author FROM "content" WHERE id = NEW.id_news INTO item_author;
    IF item_author IS NOT NULL THEN
      SELECT id FROM notification WHERE id_content = NEW.id AND type='content' INTO not_com;
      INSERT INTO notified(id_notification, id_notified)
          VALUES (not_com,item_author);
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER new_comment_trigger
    AFTER INSERT ON "comment"
    FOR EACH ROW
    EXECUTE FUNCTION notify_author();

CREATE OR REPLACE FUNCTION notify_author_vote()
RETURNS TRIGGER AS $$
DECLARE
    not_com INTEGER;
    item_author INTEGER;
BEGIN
  IF EXISTS (SELECT id FROM news_item WHERE id = NEW.id_content) THEN
    IF NOT EXISTS (
      SELECT id
      FROM notification
      WHERE id_content = NEW.id_content AND type='vote' AND id_user = NEW.id_user
    ) THEN
        INSERT INTO notification(type, id_content, id_user) VALUES ('vote', NEW.id_content, NEW.id_user);
    END IF;
    SELECT id FROM notification WHERE id_content = NEW.id_content AND type='vote' AND id_user = NEW.id_user INTO not_com;
    SELECT id_author FROM "content" WHERE id = NEW.id_content INTO item_author;
    INSERT INTO notified(id_notification, id_notified)
        VALUES (not_com,item_author)
        ON CONFLICT(id_notification, id_notified) DO UPDATE SET view = false, date = now();
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER vote_post_notification
    AFTER INSERT OR UPDATE ON "vote"
    FOR EACH ROW
    EXECUTE FUNCTION notify_author_vote();


DROP INDEX IF EXISTS date_content;
CREATE INDEX date_content ON content USING btree (date);
CLUSTER content USING date_content;

ALTER TABLE news_item
ADD COLUMN tsvectors TSVECTOR;

DROP FUNCTION IF EXISTS update_full_text_news() CASCADE;
DROP FUNCTION IF EXISTS update_full_text_content() CASCADE;


CREATE FUNCTION update_full_text_news() RETURNS TRIGGER AS $$
DECLARE
    content_text TEXT;
BEGIN
  SELECT content into content_text FROM content WHERE content.id=NEW.id;
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title),'A') ||
      setweight(to_tsvector('english', content_text),'B')
    );
  END IF;
  IF TG_OP = 'UPDATE' THEN
    IF NEW.title != OLD.title THEN
      NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.title),'A') ||
        setweight(to_tsvector('english', content_text),'B')
      );
    END IF;
  END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER update_full_text_news_trigger
BEFORE INSERT OR UPDATE ON news_item
FOR EACH ROW
EXECUTE PROCEDURE update_full_text_news();

CREATE FUNCTION update_full_text_content() RETURNS TRIGGER AS $$
DECLARE
    title_text TEXT;
BEGIN
  IF EXISTS (SELECT id FROM news_item WHERE id=NEW.id) THEN
    IF NEW.content != OLD.content THEN
      SELECT title into title_text FROM news_item WHERE news_item.id=NEW.id;
      UPDATE news_item SET tsvectors = (
        setweight(to_tsvector('english', title_text),'A') ||
        setweight(to_tsvector('english', NEW.content),'B')
      ) WHERE id=NEW.id;
    END IF;
  END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER update_full_text_content_trigger
BEFORE UPDATE ON content
FOR EACH ROW
EXECUTE PROCEDURE update_full_text_content();

CREATE INDEX search_idx ON news_item USING GIN(tsvectors);
