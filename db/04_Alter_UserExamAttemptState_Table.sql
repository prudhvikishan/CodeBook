ALTER TABLE `UserExamAttemptQuestionState` DROP  user_exam_attempt_id;

ALTER TABLE `UserExamAttemptQuestionState` ADD COLUMN user_exam_attempt_id
 INTEGER REFERENCES `UserExamAttempt`(`user_exam_attempt_id`);