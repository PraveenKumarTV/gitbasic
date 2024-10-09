package event;

import models.Donor;
import models.Student;

public class ScholarshipManager {
    private Student[] students = new Student[100];
    private Donor[] donors = new Donor[100];
    private int studentCount = 0;
    private int donorCount = 0;

    public void addStudent(Student s) {
        if (studentCount < students.length) {
            students[studentCount] = s;
            studentCount++;
        }
    }

    public void addDonor(Donor d) {
        if (donorCount < donors.length) {
            donors[donorCount] = d;
            donorCount++;
        }
    }

    public Student getStudent(String id) {
        for (int i = 0; i < studentCount; i++) {
            if (students[i].getStudentId().equals(id)) {
                return students[i];
            }
        }
        return null;
    }

    public Donor getDonor(String name) {
        for (int i = 0; i < donorCount; i++) {
            if (donors[i].getName().equals(name)) {
                return donors[i];
            }
        }
        return null;
    }
}
